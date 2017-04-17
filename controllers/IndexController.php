<?php 

 // 控制器类
 namespace app\controllers;

 use app\controllers\CommonController;

 // 引入model类
 use app\models\Product;
 use app\models\picture;

 class IndexController extends CommonController{
  public function actionIndex()
  {
    $this->layout = "layout1";
    $data['tui'] = Product::find()->where('istui = "1" and ison = "1"')->orderby('createtime desc')->limit(4)->all();
    $data['new'] = Product::find()->where('ison = "1"')->orderby('createtime desc')->limit(4)->all();
    $data['hot'] = Product::find()->where('ison = "1" and ishot = "1"')->orderby('createtime desc')->limit(4)->all();
    $data['all'] = Product::find()->where('ison = "1"')->orderby('createtime desc')->limit(8)->all();
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
 }


