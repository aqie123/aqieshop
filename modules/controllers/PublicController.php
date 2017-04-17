<?php  

namespace app\modules\controllers;

use yii\web\Controller;
// 把model载入进来
use app\modules\models\Admin;
use Yii;

class PublicController extends Controller     // 这个不能继承common，造成重定向循环
{
  public function actionLogin()
  {
    // session_start();    // 打印session.判断是否清除session
    // var_dump($_SESSION);
    // echo $_SESSION['admin']['isLogin'];
    // var_dump(Yii::$app->request->cookies);
    
    $this->layout = false;
    $model = new Admin;
    if (Yii::$app->request->isPost){
      $post = Yii::$app->request->post();
      // var_dump($post);
      if($model->login($post)){     //post数据传递给model,如果login没有错 
        $this->redirect(['default/index']);   // 跳转到后台首页
        Yii::$app->end();
      }
    }
    return $this->render("login",['model' =>$model]);
  }


  public function actionLogout()
  {
    Yii::$app->session->removeAll();
    if (!isset(Yii::$app->session['admin']['isLogin'])){
      $this->redirect(['public/login']);
      Yii::$app->end();
    }
    $this->goback();      // 跳回到上一个页面
  }

  public function actionSeekpassword()
  {
    $this->layout = false;
    $model = new Admin;
    if(Yii::$app->request->isPost) {     // 判断是否有数据提交
      $post = Yii::$app->request->post();
      if($model ->seekPass($post)){       // 邮件发送成功
        Yii::$app->session->setFlash('info','电子邮件已经发送,注意查收');
      }
    }
    return $this->render("seekpassword",['model'=>$model]);
  }

  
}
