<?php 

namespace app\modules\controllers;

use yii\web\Controller;

use Yii;

use app\modules\models\Admin;

use yii\data\Pagination;
use app\modules\controllers\CommonController;

class ManageController extends CommonController
{
  public function actionMailchangepass()
  {
    $this->layout = false;
    $time = Yii::$app->request->get("timestamp");
    $adminuser = Yii::$app->request->get("adminuser");
    $token = Yii::$app->request->get("token");
    $model = new Admin;
    $myToken = $model->createToken($adminuser,$time);
    if($token != $myToken) {
      $this->redirect(['public/login']);
      Yii::$app->end();
    }
    if(time() - $time >300){
      $this->redirect(['public/login']);
      Yii::$app->end();
    }
    if(Yii::$app->request->isPost){
      $post = Yii::$app->request->post();
      if($model->changePass($post)){
        Yii::$app->session->setFlash('info','密码修改成功');
        // $this->redirect(['public/login']);
      }
    }
    $model->adminuser = $adminuser;
    return $this->render("mailchangepass",['model'=>$model]);
  }

  public function actionManagers()          // 加载管理员页面,并实现分页
  {
    $this->layout = "layout1";
    // 实现查询
    $model= Admin::find();
    $count = $model->count();
    $pageSize = Yii::$app->params['pageSize']['manage'];            // 接收配置文件里的pageSize
    $pager = new Pagination(['totalCount' => $count,'pageSize'=>$pageSize]);
    $managers = $model->offset($pager->offset)->limit($pager->limit)->all();
    return $this->render("managers",['managers'=>$managers,'pager'=>$pager]);
  }

  public function actionReg()          // 添加管理员
  {
    $this->layout = 'layout1';
    $model = new Admin;
    if (Yii::$app->request->isPost){      // 有post属性提交
      $post = Yii::$app->request->post();
      if ($model->reg($post)) {
        Yii::$app->session->setFlash('info','添加成功');
      } else {
        Yii::$app->session->setFlash('info','添加失败');
      }
    }
    $model->adminpass = '';
    $model->adminuser = '';
    $model->repass = '';
    $model->adminemail = '';
    return $this->render('reg',['model' =>$model]);
  }

   public function actionDel()    // 删除管理员
   {
      $adminid = (int)Yii::$app->request->get("adminid");
      if(empty($adminid)) {       //如果用户id为空
        $this->redirect(['manage/managers']);
      }
      $model = new Admin;
      if($model->deleteAll('adminid=:id',[':id' => $adminid])){
        Yii::$app->session->setFlash('info','删除成功');
        $this->redirect(['manage/managers']);
      }
   } 

   public function actionChangeemail()
   {
    $this->layout = 'layout1';
    // 注意要引入model
    $model = Admin::find()->where('adminuser = :user',[':user'=>Yii::$app->session['admin']['adminuser']])->one();
    if(Yii::$app->request->isPost){
      $post = Yii::$app->request->post();         // 如果是post提交
      if($model->changeemail($post)){
        Yii::$app->session->setFlash('info','修改邮箱成功');           //显示提示信息
      }
    }
    $model->adminpass = '';         // 清除MD5加密的空密码
    // 把model放入模板中
    return $this->render('changeemail',['model'=>$model]);
   }

   public function actionChangepass()
   {
      $this->layout = "layout1";
      $model = Admin::find()->where('adminuser = :user',[':user'=>Yii::$app->session['admin']['adminuser']])->one();
      if(Yii::$app->request->isPost){
        $post = Yii::$app->request->post();
        if($model->changepass($post)){
          Yii::$app->session->setFlash("info","修改密码成功");    // 修改密码需要用户名，密码确认密码匹配非空
        }
      }
      $model->adminpass = '';
      $model->repass = '';
      return $this->render('changepass',['model'=>$model]);
   }
}




