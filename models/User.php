<?php 
    namespace app\models;
    use yii\db\ActiveRecord;
    use Yii;
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public $repass;
    public $loginname;
    public $loginpass;
    public $rememberMe = true;

    public static function tableName()      // 操作哪个表
    {
        return "{{%user}}";
    } 

    public function rules()
    {
        return [
            ['loginname','required','message'=>'登录用户名不能为空','on'=>['login']],
            ['openid', 'required', 'message' => 'openid不能为空', 'on' => ['qqreg']],
            ['username','required','message'=>'用户名不能为空','on'=>['reg','regbymail', 'qqreg']],
            ['openid', 'unique', 'message' => 'openid已经被注册', 'on' => ['qqreg']],
            ['username','unique','message'=>'用户名已经注册','on'=>['reg','regbymail','qqreg']],
            ['useremail','required','message'=>'用户邮箱不能为空','on'=>['reg','regbymail']],
            ['useremail', 'email', 'message' => '电子邮件格式不正确', 'on' => ['reg', 'regbymail']],
            ['useremail','unique','message'=>'用户邮箱已经注册','on'=>['reg','regbymail']],
            ['userpass','required','message'=>'用户密码不能为空','on'=>['reg','login','regbymail', 'qqreg']],
            ['repass','required','message'=>'确认密码不能为空','on'=>['reg']],
            ['repass','compare','compareAttribute'=>'userpass','message'=>'两次密码不一致','on'=>['reg','qqreg']],
            ['userpass','validatePass','on'=>['login']],        // 调用密码验证方法

        ];
    }

    public function validatePass()
    {
        if(!$this->hasErrors()) {    // 前面没有错误才去查询
            $loginname = "username";
            if(preg_match('/@/',$this->loginname)) {
                $loginname = "useremail";
            }
            // var_dump($this->loginname,$this->userpass);die;
            // 先对用户名进行验证
            $data = self::find()->where($loginname.' = :loginname',[":loginname" => $this->loginname])->one();
            if(is_null($data)){
                $this->addError("userpass","用户名或密码错误");
            }else{
                // 对密码进行验证 第一个用户登录传进来密码,第二个是表里查询到密码
                if(!Yii::$app->getSecurity()->validatePassword($this->userpass, $data->userpass)){
                    $this->addError("userpass", "用户名或者密码错误");
                }
            }

        }
    }

    public function attributeLabels()
    {
        return[
            'username'=>'用户名',
            'useremail'=>'用户邮箱',
            'userpass'=>'用户密码',
            'repass'=>'确认密码',
            'loginname'=>'用户名/电子邮箱',
            'loginpass'=>'登录密码'
        ];
    }

    /**
     * 后台添加用户
     * @param $data
     * @param string $scenario
     * @return bool
     */
    public function reg($data,$scenario = 'reg')      //后台添加用户
    {
        $this->scenario= $scenario;
        if($this->load($data) && $this->validate()){  //加载成功并且验证成功
            $this->createtime = time();
            // $this->userpass = md5($this->userpass);
            $this->userpass = Yii::$app->getSecurity()->generatePasswordHash($this->userpass);
            if($this->save(false)){   //true 验证数据， 会调用 validate() 方法，false 不验证数据，直接存储，
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * 和user表关联
     * get(什么)就是在usercontroller joinwith(什么)(后台用户联查)
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['userid'=>'userid']); 
        // user表id->profile表id
    }

    /**
     * 前台通过邮箱注册
     * @param $data (用户提交邮箱)
     * @return bool
     */
    public function regByMail($data)
    {
        $data['User']['username'] = 'aqie_'.uniqid();
        $data['User']['userpass'] = uniqid();
        $this->scenario = 'regbymail';
        if ($this->load($data) && $this->validate()) {
            // 实例化mailer类
            $mailer = Yii::$app->mailer->compose('createuser', ['userpass' => $data['User']['userpass'], 'username' => $data['User']['username']]);
            $mailer->setFrom("aqie123aqie@163.com");
            $mailer->setTo($data['User']['useremail']);
            $mailer->setSubject("啊切商城-用户邮箱注册");
            // if($mailer->send() && $this->reg($data,'regbymail')) {
            // 将邮件加入队列
            if($mailer->queue() && $this->reg($data,'regbymail')) {
                return true;
            }
        }
        return false;
    }

    /**
     * 返回用户登录实例
     * @return array|null|ActiveRecord
     */
    public function getUser(){
        return self::find()->where('username = :loginname or useremail = :loginname', [':loginname' => $this->loginname])->one();
    }
    /**
     * 前台用户登录
     * @param $data
     * @return bool
     */
    public function login($data)
    {
        $this->scenario = "login";
        if($this->load($data) && $this->validate()){
            // todo
             // var_dump($this->getUser());die;
            return Yii::$app->user->login($this->getUser(),$this->rememberMe ? 24*3600 :0);
            // 通过用户认证体系实现
            /*
            $lifetime = $this->rememberMe ? 24*3600 :0;  //没有勾选则不写入
            $session = Yii::$app->session;
            // cookie存储登录session有效期
            session_set_cookie_params($lifetime);
            $session['loginname'] = $this->loginname;
            $session['isLogin'] = 1;                //isLogin从这里开始写入的
            return (bool)$session['isLogin'];
            */
        }
        return false;
    }

    // 实现接口
    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
        return static::findone($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
        //这个方法不用
        return null;
    }
    public  function getId()
    {
        return $this->userid;

    }
    // 后面两个可以用来验证cookie
    public function getAuthKey()
    {
        return '';
    }

    public function validateAuthKey($authKey)
    {
        return true;
    }

}



