<?php 
namespace app\controllers;

use app\controllers\CommonController;
use Yii;
use app\models\product;
use yii\data\Pagination;

class ProductController extends CommonController{

  public $layout = "layout2";
  public function actionIndex(){
    // view/product/index.php   商品列表
    $cid = Yii::$app->request->get("cateid");
    $where = "cateid = :cid and ison='1'";
    $params = [':cid' =>$cid];
    $model = Product::find()->where($where,$params);
    $all = $model->asArray()->all();

    $count = $model->count();
    $pageSize = Yii::$app->params['pageSize']['frontproduct'];
    $pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
    $all = $model->offset($pager->offset)->limit($pager->limit)->asArray()->all();

    $tui = $model->where($where.'and istui = \'1\'',$params)->orderby('createtime desc')->limit(5)->asArray()->all();
    $hot = $model->where($where.'and ishot = \'1\'',$params)->orderby('createtime desc')->limit(8)->asArray()->all();
    $sale = $model->where($where.'and issale = \'1\'',$params)->orderby('createtime desc')->limit(5)->asArray()->all();
    return $this->render("index",[
      'sale' => $sale,
      'hot'=>$hot,
      'tui'=>$tui,
      'all'=>$all,
      'count'=>$count,
      'pager'=>$pager
    ]);
  }

  public function actionDetail(){
    //view/product/detail.php   商品详情页面
    $productid = Yii::$app->request->get("productid");
    $product = Product::find()->where('productid = :id',[':id' => $productid])->asArray()->one();
    $data['all'] = Product::find()->where('ison = "1"')->orderby('createtime desc')->limit(7)->all();
    return $this->render("detail",['product' =>$product,'data'=>$data]);
  }
}



