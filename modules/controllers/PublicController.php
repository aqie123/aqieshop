<?php  

namespace app\modules\controllers;

use yii\web\Controller;
// 把model载入进来
use app\modules\models\Admin;
use Yii;

class PublicController extends CommonController     // 这个不能继承common，造成重定向循环  改变了认证系统
{
  protected $except = ["login","seekpassword"];
    /**
     * 后台登录操作(页面提交给自己)
     * @return string
     */
  public function actionLogin()
  {
      // 打印session.判断是否清除session
     //session_start();  var_dump($_SESSION);die;
    // echo $_SESSION['admin']['isLogin'];
   // var_dump(Yii::$app->request->cookies);
    // echo  Yii::$app->request->userIP;die;
    
    $this->layout = false;
    $model = new Admin;
    // post提交返回真
    if (Yii::$app->request->isPost){
      $post = Yii::$app->request->post();
       //var_dump($post);
      // post数据传递给model里面login方法
      if($model->login($post)){     //post数据传递给model,如果login返回真
        $this->redirect(['default/index']);   // 跳转到后台首页
        Yii::$app->end();
      }
    }
    return $this->render("login",['model' =>$model]);
  }

    /**
     * 后台管理员退出登录
     * @return \yii\web\Response
     */
  public function actionLogout()
  {
      /*
    Yii::$app->session->removeAll();
    if (!isset(Yii::$app->session['admin']['isLogin'])){
      $this->redirect(['public/login']);
      Yii::$app->end();
    }
      */
      Yii::$app->admin->logout(false);
      return  $this->goback();      // 跳回到上一个页面   退出这里并不一定到登录页面,如果记录登录状态话
  }

    /**
     * 后台管理员找回密码(页面提交给自己)
     * @return string
     */
  public function actionSeekpassword()
  {
    $this->layout = false;
    $model = new Admin;
    // 判断是否有数据提交
    if(Yii::$app->request->isPost) {
      $post = Yii::$app->request->post();
      // 邮件发送成功
      if($model ->seekPass($post)){
        Yii::$app->session->setFlash('info','电子邮件已经发送,注意查收');
      }
    }
    return $this->render("seekpassword",['model'=>$model]);
  }

  
}
