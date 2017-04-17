<?php 

namespace app\modules\controllers;
use yii\web\Controller;
use Yii;
use app\models\Category;   // 导入model
use app\modules\controllers\CommonController;

// 一般控制器里面有多少方法对应多少php页面;有多少model对应几张表

class CategoryController extends CommonController
{
  // 显示分类列表
  public function actionList()   // 任务：每页显示五个顶级分类，点击时候查询出所有子分类
  {
    $this->layout = "layout1";
    $model = new Category();
    $lists = $model->getTreeList();
    return $this->render("list",['lists'=>$lists]);
  }

  public function actionAdd()
  {
    $model = new Category(); 
    $list = $model->getOptions();   //商品分类
    
    $this->layout = "layout1";
    
    /*
    $cates = $model ->getData();      // 把数据读取出来
    $tree= $model->getTree($cates);
    var_dump($tree);exit;             // 打印出json数组
    $tree = $model ->setPrefix($tree);
    var_dump($tree);exit;               //加完前缀
    */
    // $list = array_merge([0=>'添加顶级分类'],$list);        这么写会出问题
    if(Yii::$app->request->isPost) {
      $post = Yii::$app->request->post();
      if($model->add($post)) {
        Yii::$app->session->setFlash('info','添加分类成功');
      }
    }
    $model->title='';
    // 数据传递给模板
    return $this->render("add",['list'=>$list,'model'=>$model]);
  }

  public function actionMod()         // 修改分类列表
  {
    $this->layout = "layout1";
    $cateid = Yii::$app->request->get("cateid");    // 从页面接收数据,拿到model对象
    $model = Category::find()->where('cateid=:id',[':id' => $cateid])->one();
    if(Yii::$app->request->isPost){
      $post = Yii::$app->request->post();
      if($model->load($post) && $model->save()) {
        Yii::$app->session->setFlash('info','修改成功');
      }
    }
    $list = $model->getOptions();
    return $this->render('add',['model'=>$model,'list'=>$list]);
  }

  public function actionDel()    // 删除分类
  {
    try{
      $cateid = Yii::$app->request->get('cateid');
      if(empty($cateid)) {
        throw new \Exception('参数错误');
      }
      // 如果有子类不允许删除
      $data = Category::find()->where('parentid = :pid',[":pid"=>$cateid])->one();
      if($data){    // 有子类
        throw new \Exception('该分类下有子类,不允许删除');
      }
      if(!Category::deleteAll('cateid = :id',[':id'=>$cateid])) {
        throw new \Exception('删除失败');
      }
    }catch(\Exception $e) {
      Yii::$app->session->setFlash('info',$e->getMessage());
    }
    return $this->redirect(['category/list']);
  }


}


