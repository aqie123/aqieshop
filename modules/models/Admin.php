<?php 
  // 推荐类名和表名一致
  namespace app\modules\models;

  use yii\db\ActiveRecord;

  use Yii;


  class Admin extends ActiveRecord
  {
    public $rememberMe = true;
    public $repass;
    public static function tableName()
    {    
      return "{{%admin}}";
    }

    public function attributeLabels()
    {
      return [
        'adminuser' => '管理员账号',
        'adminemail' => '管理员邮箱',
        'adminpass' => '管理员密码',
        'repass' => '确认密码',
      ];
    }

    public function rules()
    {
      return [
        ['adminuser','required','message'=>'管理员账号不能为空','on' =>['login','seekpass','changepass','adminadd','changeemail']],
        ['adminpass','required','message'=>'管理员密码不能为空','on' => ['login','changepass','adminadd','changeemail']],
        ['rememberMe','boolean','on' => ['login']],
        ['adminpass','validatePass','on' => ['login','changeemail']],     // 验证密码是否正确
        ['adminemail','required','message'=>'电子邮箱不能为空','on' =>['seekpass','adminadd','changeemail']],
        ['adminemail','email','message'=>'电子邮箱格式不正确','on' =>['seekpass','adminadd','changeemail']],
        ['adminemail','unique','message'=>'电子邮箱已被注册','on' =>['adminadd','changeemail']],
        ['adminuser','unique','message'=>'用户名已被注册','on' =>['adminadd']],
        ['adminemail','validatemail','on' =>['seekpass']],          // 验证邮箱是否正确
        ['repass','required','message'=>'确认密码不能为空','on'=>['changepass','adminadd']],
        ['repass','compare','compareAttribute' => 'adminpass','message'=>'两次密码输入不一致','on'=>['changepass','adminadd']],
      ];
    }

    public function validatePass()    // 回调函数验证数据是否正确
    {
      if (!$this->hasErrors()) {      // 先判断前面是否验证正确，没错再查询数据库
        $data = self::find()->where('adminuser=:user and adminpass=:pass',[":user" =>$this->adminuser,":pass"=>md5($this->adminpass)])->one();
        if (is_null($data)) {     //查询不出来，数据类型为空
          $this->addError("adminpass","用户名或密码错误");
        }
      }
    }

    public function login($data)        //执行验证，验证成功把数据写入session
    {
      $this->scenario = "login";
      if($this->load($data) && $this->validate()){   //载入成功并且验证成功，执行登录
        // 做点有意义的事

        $lifetime = $this->rememberMe ? 24*3600 : 0;
        $session = Yii::$app->session;
        session_set_cookie_params($lifetime);      //设置保存session id的cookie有效期
        $session['admin'] = [                     //将用户名和登录状态存进session
          'adminuser' => $this->adminuser,
          'isLogin' => 1,
        ];
        // 更新操作 数据库插入登录时间和登录ip    后面是限制条件，给当前用户插入
        $this->updateAll(['logintime'=>time(),'loginip'=>ip2long(Yii::$app->request->userIP)],'adminuser = :user',[':user'=>$this->adminuser]);
        return (bool)$session['admin']['isLogin'];
      }
      return false;
    }

    public function seekPass($data)
    {
      $this->scenario = "seekpass";
      if ($this->load($data) && $this->validate()){
        // 验证成功发送邮件
        $time = time();
        $token = $this->createToken($data['Admin']['adminuser'],$time);
        $mailer = Yii::$app->mailer->compose('seekpass',['adminuser' =>$data['Admin']['adminuser'],'time'=>$time,'token'=>$token]);
        $mailer->setFrom("aqie123aqie@163.com");
        $mailer->setTo($data['Admin']['adminemail']);  
        // 接收验证通过后，表单传递过来邮箱
        $mailer->setSubject("找回密码");
        if ($mailer->send()) {
          return true;
        }
      }
      return false;
    }

    public function createToken($adminuser,$time)
    {
      return md5(md5($adminuser).base64_encode(Yii::$app->request->userIP).md5($time));
    }

    public function validatemail($value='')
    {
      if (!$this->hasErrors()){
        $data = self::find()->where('adminuser = :user and adminemail = :email',[':user' =>$this->adminuser,':email'=>$this->adminemail])->one();
        // 这里用到独立索引，查询用户名和邮箱
        if (is_null($data)){
          $this->addError("adminemail","管理员账号和邮箱不匹配");
        }

      }
    }

    public function changePass($data)
    {
      $this->scenario = "changepass";
      if($this->load($data) && $this->validate()) {
        // 实现数据库密码修改****************数组后面是条件
        return (bool)$this->updateAll(['adminpass' =>md5($this->adminpass)],'adminuser=:user',[':user'=>$this->adminuser]);

      }
      return false;
    }

    public function reg($data)      
    // 后台注册添加管理员操作验证成功,进行加密,再执行添加
    {
      $this->scenario = 'adminadd';
      if ($this->load($data) && $this->validate()) {
        $this->adminpass = md5($this->adminpass);
        $this->createtime = time();
        if($this->save(false)){  // save不做验证，
          return true;        // 添加成功返回真
        }
        return false;
      }
      return false;
    }

    public function changeEmail($data){
      $this->scenario = 'changeemail';
      if($this->load($data) && $this->validate()){   //用户名非空，密码匹配，邮箱非空格式正确,是否已经注册
        return (bool)$this->updateAll(['adminemail' => $this->adminemail],'adminuser = :user',[':user' =>$this->adminuser]);     // 后面是条件
      }
      return false;       // 验证失败返回假
    }

  }
  


