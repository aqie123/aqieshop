<?php 
namespace app\modules\controllers;
use yii\web\Controller;
use Yii;
use app\models\Product;
use app\models\Category;
use yii\data\Pagination;
use crazyfd\qiniu\Qiniu;
use app\modules\controllers\CommonController;


class ProductController extends CommonController
{
  public function actionList()     // 商品列表
  {
    $model = Product::find()->joinWith('category');  // 在product model里面方法返回
    $count = $model->count();
    $pageSize = Yii::$app->params['pageSize']['product'];
    $pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
    $products = $model->offset($pager->offset)->limit($pager->limit)->all();
    $this->layout = 'layout1';
    return $this->render("product",['pager'=>$pager,'products'=>$products]);

  }

  public function actionAdd()    // 商品添加
  {
    $this->layout = false;
    $model = new Product;
    $cate = new Category;
    $list = $cate->getOptions();
    unset($list[0]);           // 把默认去掉
    if(Yii::$app->request->isPost){
      $post = Yii::$app->request->post();
        // var_dump($post);die;
      $pics = $this->upload();
      if(!$pics) {
        $model->addError('cover','封面不能为空');
      }else{   //拿到图片后
        $post['Product']['cover'] = $pics['cover'];
        $post['Product']['pics'] = $pics['pics'];
      }
      if($pics && $model->add($post)){   // 如果有图片并且图片添加
        Yii::$app->session->setFlash('info','添加成功');

      }else{
        Yii::$app->session->setFlash('info','添加失败');
      }
      

    }
    return $this->render("add",['opts'=>$list,'model'=>$model]);

  }

  private function upload()     // 七牛图片上传
  {
    if($_FILES['Product']['error']['cover']>0){   // 有错误
      return  false;
    }
    $qiniu = new Qiniu(Product::AK,Product::SK,Product::DOMAIN,Product::BUCKET);
    $key = uniqid();
    $qiniu->uploadFile($_FILES['Product']['tmp_name']['cover'],$key);
    $cover = $qiniu->getLink($key);
    $pics = [];
    foreach($_FILES['Product']['tmp_name']['pics'] as $k=>$file) {
      if($_FILES['Product']['error']['pics'][$k]>0) { // 有错误
        continue;       // 跳过本次循环
      }
      $key = uniqid();
      $qiniu->uploadFile($file,$key);
      $pics[$key] = $qiniu->getLink($key);
    }
    return ['cover' =>$cover,'pics'=>json_encode($pics)];    // json格式化
    
  }
   

  public function actionOn()  //商品上架
  {
    // $this->layout = false;
    $productid = Yii::$app->request->get("productid");
    Product::updateAll(['ison'=>'1'],'productid = :pid',[':pid'=>$productid]);
    return $this->redirect(['product/list']);        // 调用的控制器里面方法
  }

  public function actionOff()  // 商品下架
  {
    $productid = Yii::$app->request->get("productid");
    Product::updateAll(['ison'=>'0'],'productid = :pid',[':pid'=>$productid]);
    return $this->redirect(['product/list']);
  }

  public function actionMod()    // 修改商品  和添加商品调用同一个模板
  {
    $this->layout = false;
    $cate = new Category;
    $list = $cate->getOptions();
    unset($list[0]);
    $productid = Yii::$app->request->get("productid");
    $model = Product::find()->where("productid = :pid",[':pid'=>$productid])->one();
    if(Yii::$app->request->isPost) {      // 如果提交成功
      $post = Yii::$app->request->post();
        // var_dump($post);die;
      $qiniu = new Qiniu(Product::AK,Product::SK,Product::DOMAIN,Product::BUCKET);
      $post['Product']['cover'] = $model->cover;
      // echo "<pre>";var_dump($_FILES);die;
      if($_FILES["Product"]['error']['cover'] ==0) {
        $key = uniqid();
        $qiniu->uploadFile($_FILES['Product']['tmp_name']['cover'],$key);
        $post['Product']['cover'] = $qiniu->getLink($key);
        $qiniu->delete(basename($model->cover));
      }
      $pics = [];
      foreach($_FILES['Product']['tmp_name']['pics'] as $k =>$file) {
        if($_FILES['Product']['error']['pics'][$k]>0){
          continue;
        }
        $key = uniqid();
        $qiniu->uploadfile($file,$key);
        $pics[$key] = $qiniu->getLink($key);
      }
      $post["Product"]['pics']=json_encode(array_merge((array)json_decode($model->pics,true),$pics));
      if($model->load($post) && $model->save()) {
        Yii::$app->session->setFlash('info', '修改成功');
      }
    }
    return $this->render('add',['model'=>$model,'opts'=>$list]);
  }

  public function actionRemovepic()    // 删除存在七牛的图片
  {
    $this->layout = false;
    $key = Yii::$app->request->get("key");
    $productid = Yii::$app->request->get("productid");
    $model = Product::find()->where('productid =:pid',[':pid'=>$productid])->one();
    $qiniu = new Qiniu(Product::AK,Product::SK,Product::DOMAIN,Product::BUCKET);
    $qiniu->delete($key);
    $pics = json_decode($model->pics,true);
    unset($pics[$key]);   // 这个函数
    // Product::undateAll(['pics'=>json_encode($pics)], 'productid = :pid',[':pid'=>$productid]);
    Product::updateAll(['pics' => json_encode($pics)], 'productid = :pid', [':pid' => $productid]);
    return $this->redirect(['product/mod','productid'=>$productid]);
  }

  public function actionDel()    //删除商品
  {
    $productid = Yii::$app->request->get("productid");
    $model = Product::find()->where('productid = :pid',[':pid' =>$productid])->one();
    $key = basename($model->cover);
    $qiniu = new Qiniu(Product::AK,Product::SK,Product::DOMAIN,Product::BUCKET);
    $qiniu->delete($key);
    $pics = json_decode($model->pics,true);
    foreach($pics as $key=>$file) {
      $qiniu->delete($key);
    }
    Product::deleteAll('productid = :pid',[":pid" => $productid]);
    return $this->redirect(['product/list']);

  }


}



