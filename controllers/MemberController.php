<?php 

namespace app\controllers;
use app\controllers\CommonController;
use app\models\User;

use yii;

class MemberController extends CommonController{
  // public $layout = "layout2";
 protected $except = ['auth', 'logout', 'reg', 'qqreg', 'qqlogin', 'qqcallback'];

  public function actionAuth()        // 前台用户登录
  {
    $this->layout = 'layout2';
    if(Yii::$app->request->isGet) {
      $url = Yii::$app->request->referrer;
      if(empty($url)) {
        $url = "/";
      }
      Yii::$app->session->setFlash('referrer',$url);
    }
    $model = new User;
    if(Yii::$app->request->isPost){
      $post = Yii::$app->request->post();
      if($model->login($post)) {
        $url = Yii::$app->session->getFlash('referrer');
        return $this->redirect($url);
      }
    }
    $model->loginname = '';
    $model->userpass = '';
    return $this->render("auth",['model'=>$model]);
  }


    /**
     * 前台用户邮箱注册
     * @return string
     */
  public function actionReg()
  {
    $this->layout="layout2";
    $model = new User;
    if (Yii::$app->request->isPost) {       // post提交了数据
      $post = Yii::$app->request->post();   // 接收post数据
      if($model->regByMail($post)){     // 执行regByMail方法
        Yii::$app->session->setFlash('info','电子邮件发送成功');
      }else {
        Yii::$app->session->setFlash('info','电子邮件发送失败');
      }
    }
      $model->userpass = '';
    return $this->render('auth',['model'=>$model]);
  }

    /**
     * 前台用户退出
     * @return yii\web\Response
     */
  public function actionLogout()
  {
      /*
    Yii::$app->session->remove('loginname');
    Yii::$app->session->remove('isLogin');
    if(!isset(Yii::$app->session['isLogin'])) {
      return $this->goBack(Yii::$app->request->referrer);

    }
       */
      Yii::$app->user->logout(false);
      // return $this->goBack(Yii::$app->request->referrer);
      $this->redirect(['member/auth']);
  }

    /**
     * qq登录
     */
    public function actionQqlogin()
    {
        require_once("../vendor/qqlogin/qqConnectAPI.php");
        $qc = new \QC();
        $qc->qq_login();
    }

    /**
     * qq callback
     * @return yii\web\Response
     */
    public function actionQqcallback()
    {
        require_once("../vendor/qqlogin/qqConnectAPI.php");
        $auth = new \OAuth();
        $accessToken = $auth->qq_callback();
        $openid = $auth->get_openid();
        $qc = new \QC($accessToken, $openid);
        $userinfo = $qc->get_user_info();
         // echo "<pre>";var_dump($userinfo);die;           // qq用户所有信息

        $session = Yii::$app->session;
         $session['userinfo'] = $userinfo;        // 用户信息写入session  这里先不写入 还是要写入才显头像和
        $session['openid'] = $openid;
        // 判断openid在用户表是否存在 存在跳转回首页,不存在进入qq注册页面
        if ($model = User::find()->where('openid = :openid', [':openid' => $openid])->one()) {
            // 写入用户认证体系
            Yii::$app->user->login($model);
            return $this->redirect(['index/index']);
        }
        return $this->redirect(['member/qqreg']);
    }

    /**
     * 未注册用户加载qq登录模板
     * @return string|yii\web\Response
     */
    public function actionQqreg()
    {
        $this->layout = "layout2";
        $model = new User;
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            // var_dump($post);die;
            $session = Yii::$app->session;
            $post['User']['openid'] = $session['openid'];
            if ($model->reg($post, 'qqreg')) {
                // 登陆成功将用户信息写入到认证体系
                $model = User::find()->where('openid = :openid', [':openid' => $post['User']['openid']])->one();
                // echo "<pre>";var_dump($model);die;
                Yii::$app->user->login($model);

                return $this->redirect(['index/index']);
            }
        }
        return $this->render('qqreg', ['model' => $model]);
    }

}
