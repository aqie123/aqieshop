<?php 

namespace app\controllers;
use yii\web\Controller;
use app\models\Product;
class TestController extends Controller
{
  public function actionTest()
  {
    // echo '测试';
    $this->layout = false;
    $model = Product::find()->where('ison = "1" and issale = "1"')->orderby('createtime desc')->limit(3)->all();
    return $this->render('test',['model'=>$model]);
  }
  
}






