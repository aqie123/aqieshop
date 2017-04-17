<?php 

namespace app\modules\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use app\models\User;
use app\models\Profile;
use Yii;

use app\modules\controllers\CommonController;

class UserController extends CommonController
{
  public function actionUsers()   // 用户列表
  {
    
    $model = User::find()->joinWith('profile');   //连表查询
    $count = $model->count();
    $pageSize = Yii::$app->params['pageSize']['user'];  // 在config/params配置
    $pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
    $users = $model->offset($pager->offset)->limit($pager->limit)->all();               // 循环遍历的值 是model经过分页限制的
    $this->layout = "layout1";
    return $this->render('users',['users'=>$users,'pager'=>$pager]);
  }

  public function actionReg()   // 添加用户
  {
    $this->layout = "layout1";
    $model = new User;
    if(Yii::$app->request->isPost){       //如果有表单提交
      $post = Yii::$app->request->Post();  //接收post数据
      if($model->reg($post)){     // 把post数据扔给model里面reg方法,返回真
        Yii::$app->session->setFlash('info','添加成功');    // 输出信息,到页面显示
      }
    }
    $model->username = '';
    $model->useremail = '';
    $model->userpass = '';
    $model->repass = '';
    return $this->render("reg",['model' =>$model]);
  }

  public function actionDel()  // 删除用户
  {
    try{
      $userid= (int)Yii::$app->request->get('userid');
      if (empty($userid)) {
        throw new \Exception();
      }
      $trans = Yii::$app->db->beginTransaction();   // 创建事务
      if ($obj = Profile::find()->where('userid=:id',[':id'=>$userid])->one())
      {
        $res = Profile::deleteAll('userid = :id',[':id'=>$userid]);
        if(empty($res)){
          throw new \Exception();
        }
      }
      if (!User::deleteAll('userid = :id',[':id'=>$userid])){
        throw new \Exception();
      }
      $trans->commit();    // 没有问题提交
    } catch(\Exception $e) {   //抛出异常回滚
      if(Yii::$app->db->getTransaction()) {
        $trans->rollback();
      }
    }
    $this->redirect(['user/users']);   
  }


}

