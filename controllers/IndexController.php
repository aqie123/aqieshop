<?php 

 // 控制器类
 namespace app\controllers;

 use app\controllers\CommonController;
 use Yii;
 // 引入model类
 use app\models\Product;
 use app\models\Picture;

 class IndexController extends CommonController{
  protected $except = ['index'];

  public function actionIndex()
  {
      $this->layout = "layout1";
      $dep = new \yii\caching\DbDependency([
          'sql' => 'select max(updatetime) from {{%product}} where ison = "1"',
      ]);   // 依赖就是查询更新时候,缓存也会更新
      $data['tui'] = Product::getDb()->cache(function (){
          return Product::find()->where('istui = "1" and ison = "1"')
              ->orderby('createtime desc')->limit(4)->all();
      }, 60, $dep);
      $data['new'] = Product::getDb()->cache(function (){
          return Product::find()->where('ison = "1"')
              ->orderby('createtime desc')->limit(4)->all();
      }, 60, $dep);
      $data['hot'] = Product::getDb()->cache(function (){
          return Product::find()->where('ison = "1" and ishot = "1"')
              ->orderby('createtime desc')->limit(4)->all();
      }, 60, $dep);
      $data['all'] = Product::getDb()->cache(function (){
          return Product::find()->where('ison = "1"')
              ->orderby('createtime desc')->limit(7)->all();
      }, 60, $dep);
      $data['sale'] = Product::getDb()->cache(function(){
          return Product::find()->where('ison = "1" and issale = "1"')
              ->orderBy("price desc")->limit(8)->all();
      },60, $dep);

    // 对图片进行查询缓存
    $pic1 = Picture::find()->where('pictureid = "1"')->all();
    $pic2 = Picture::find()->where('pictureid = "2"')->all();
    $pic3 = Picture::find()->where('pictureid = "3"')->all();
    $pic4 = Picture::find()->where('pictureid = "4"')->all();
    
    return $this->render("index",[
      'data'=>$data,
      'pic1'=>$pic1,
      'pic2'=>$pic2,
      'pic3'=>$pic3,
      'pic4'=>$pic4,
    ]);     // 首页

  }

  public function actionError(){
      echo '加载404页面';
  }

 }


