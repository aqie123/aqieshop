<?php 

namespace app\controllers;
use app\controllers\CommonController;
use app\models\User;

use yii;

class MemberController extends CommonController{
  // public $layout = "layout2";

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


  public function actionReg()    // 前台邮箱注册
  {
    $model = new User;
    if (Yii::$app->request->isPost) {       // post提交了数据
      $post = Yii::$app->request->post();   // 接收post数据
      if($model->regByMail($post)){     // 执行regByMail方法
        Yii::$app->session->setFlash('info','电子邮件发送成功');
      }else {
        Yii::$app->session->setFlash('info','电子邮件发送失败');
      }
    }  
    $this->layout="layout2";
    return $this->render('auth',['model'=>$model]);
  }

  public function actionLogout()   //前台用户退出
  {
    Yii::$app->session->remove('loginname');
    Yii::$app->session->remove('isLogin');
    if(!isset(Yii::$app->session['isLogin'])) {
      return $this->goBack(Yii::$app->request->referrer);
    }
  }
}
