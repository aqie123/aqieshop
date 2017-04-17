<?php 
    namespace app\models;
    use yii\db\ActiveRecord;
    use Yii;
class User extends ActiveRecord
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
            ['username','required','message'=>'用户名不能为空','on'=>['reg','regbymail']],
            ['username','unique','message'=>'用户名已经注册','on'=>['reg','regbymail']],
            ['useremail','required','message'=>'用户邮箱不能为空','on'=>['reg','regbymail']],
            ['useremail', 'email', 'message' => '电子邮件格式不正确', 'on' => ['reg', 'regbymail']],
            ['useremail','unique','message'=>'用户邮箱已经注册','on'=>['reg','regbymail']],
            ['userpass','required','message'=>'用户密码不能为空','on'=>['reg','login','regbymail']],
            ['repass','required','message'=>'确认密码不能为空','on'=>['reg']],
            ['repass','compare','compareAttribute'=>'userpass','message'=>'两次密码不一致','on'=>'reg'],
            ['userpass','validatePass','on'=>['login']],

        ];
    }

    public function validatePass()
    {
        if(!$this->hasErrors()) {    // 前面没有错误才去查询
            $loginname = "username";
            if(preg_match('/@/',$this->loginname)) {
                $loginname = "useremail";
            }
            $data = self::find()->where($loginname.' = :loginname and userpass = :pass',[":loginname" => $this->loginname,':pass'=>md5($this->userpass)])->one();
            if(is_null($data)){
                $this->addError("userpass","用户名或密码错误");
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
            'useremail'=>'电子邮箱',
            'loginname'=>'用户名/电子邮箱',
            'loginpass'=>'登录密码'
        ];
    }

    public function reg($data,$scenario = 'reg')      //后台添加用户
    {
        $this->scenario= $scenario;
        if($this->load($data) && $this->validate()){  //加载成功并且验证成功
            $this->createtime = time();
            $this->userpass = md5($this->userpass);
            if($this->save(false)){   //true 验证数据， 会调用 validate() 方法，false 不验证数据，直接存储，
                return true;
            }
            return false;
        }
        return false;
    }

    public function getProfile()   //get什么就是在usercontroller填什么(后台用户联查)
    {
        return $this->hasOne(Profile::className(), ['userid'=>'userid']); 
        // user表->profile表
    }

    public function regByMail($data)   // 前台通过邮箱注册
    {
        $data['User']['username'] = 'aqie_'.uniqid();
        $data['User']['userpass'] = uniqid();
        $this->scenario = 'regbymail';
        if ($this->load($data) && $this->validate()) {
            $mailer = Yii::$app->mailer->compose('createuser', ['userpass' => $data['User']['userpass'], 'username' => $data['User']['username']]);
            $mailer->setFrom("aqie123aqie@163.com");
            $mailer->setTo($data['User']['useremail']);
            $mailer->setSubject("啊切商城-用户邮箱注册");
            if($mailer->send() && $this->reg($data,'regbymail')) {
                return true;
            }
        }
        return false;
    }

    public function login($data)
    {
        $this->scenario = "login";
        if($this->load($data) && $this->validate()){
            // do something useful
            $lifetime = $this->rememberMe ? 24*3600 :0;  //没有勾选则不写入
            $session = Yii::$app->session;
            session_set_cookie_params($lifetime);
            $session['loginname'] = $this->loginname;
            $session['isLogin'] = 1;                //isLogin从这里开始写入的
            return (bool)$session['isLogin'];
        }
        return false;
    }


}



