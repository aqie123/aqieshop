<?php 

namespace app\modules\controllers;

 use yii\web\Controller;
use Yii;
use app\modules\models\Admin;
use yii\data\Pagination;
use app\modules\controllers\CommonController;
use app\modules\models\Rbac;

class ManageController extends CommonController{
  protected $except = ['mailchangepass'];
    /**
     * 通过点击链接完成必要验证，并实现邮箱修改密码
     * @return string
     */
  public function actionMailchangepass()
  {
    $this->layout = false;
    $time = Yii::$app->request->get("timestamp");
    $adminuser = Yii::$app->request->get("adminuser");
    $token = Yii::$app->request->get("token");
    $model = new Admin;
    $myToken = $model->createToken($adminuser,$time);
    // 令牌是正确的
    if($token != $myToken) {
        echo "<script>alert('令牌不对')</script>";
      $this->redirect(['public/login']);
      Yii::$app->end();
    }
    // 间隔时间小于五分钟
    if(time() - $time >300){
       echo "<script>alert('时间不对')</script>";
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
    $model->adminpass = '';
    $model->repass  = '';
    $model->adminuser = $adminuser;
    return $this->render("mailchangepass",['model'=>$model]);
  }

    /**
     * 加载管理员页面,并实现分页
     * @return string
     */
  public function actionManagers()
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

    /**
     * 添加管理员
     * @return string
     */
  public function actionReg()
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
    $model->repass = '';

    return $this->render('reg',['model' =>$model]);
  }

    /**
     * 删除管理员
     */
   public function actionDel()
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

    /**
     * 后台直接修改管理员邮箱
     * @return string
     */
   public function actionChangeemail()
   {
    $this->layout = 'layout1';
    // 注意要引入model
    $model = Admin::find()->where('adminuser = :user',[':user'=>\Yii::$app->admin->identity->adminuser])->one();
    if(Yii::$app->request->isPost){
      $post = Yii::$app->request->post();         // 如果是post提交
      if($model->changeemail($post)){
        Yii::$app->session->setFlash('info','修改邮箱成功');           //显示提示信息
      }
    }
     $model->adminpass = '';         // 清除密码
    // 把model放入模板中
    return $this->render('changeemail',['model'=>$model]);
   }

    /**
     * 后台直接修改管理员密码
     * @return string
     */
   public function actionChangepass()
   {
      $this->layout = "layout1";
      // echo \Yii::$app->admin->identity->adminuser;die;  获取用户名
      $model = Admin::find()->where('adminuser = :user',[':user'=>\Yii::$app->admin->identity->adminuser])->one();
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

    /**
     * 给管理员分配权限
     * @param $adminid
     * @return string
     * @throws \Exception
     * @throws \yii\web\NotFoundHttpException
     */
   public function actionAssign($adminid)
   {
       $this->layout= 'layout1';
       $adminid = (int)$adminid;
       if (empty($adminid)) {
           throw new \Exception('管理员id为空,参数错误');
       }
       $admin = Admin::findOne($adminid);
       if (empty($admin)) {
           throw new \yii\web\NotFoundHttpException('admin not found');
       }

       // 点击授权，进行判断
       if (Yii::$app->request->isPost) {
           $post = Yii::$app->request->post();
           $children = !empty($post['children']) ? $post['children'] : [];
           if (Rbac::grant($adminid, $children)) {
               Yii::$app->session->setFlash('info', '授权成功');
           }
       }

       $auth = Yii::$app->authManager;
       $roles = Rbac::getOptions($auth->getRoles(), null);
       $permissions = Rbac::getOptions($auth->getPermissions(), null);
       // var_dump($roles,$permissions);die;  // 拿到所有角色权限
       // 获取当前角色所有权限
       $children = Rbac::getChildrenByUser($adminid);
       // var_dump($children);die;

       return $this->render('_assign', ['children' => $children, 'roles' => $roles, 'permissions' => $permissions, 'admin' => $admin->adminuser]);
   }
}




