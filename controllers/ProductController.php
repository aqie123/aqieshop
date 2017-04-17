<?php 
namespace app\controllers;

use app\controllers\CommonController;
use Yii;
use app\models\product;
use yii\data\Pagination;
use app\models\ProductSearch;

class ProductController extends CommonController{
  protected $except = ['index', 'detail'];
  public $layout = "layout2";
  /**
   * 查询出商品展示到index首页
   */
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

    $tui = $model->where($where.'and istui = \'1\'',$params)
        ->orderby('createtime desc')
        ->limit(5)->asArray()->all();
    $hot = $model->where($where.'and ishot = \'1\'',$params)
        ->orderby('createtime desc')
        ->limit(8)->asArray()->all();
    $sale = $model->where($where.'and issale = \'1\'',$params)
        ->orderby('createtime desc')
        ->limit(5)->asArray()->all();
    return $this->render("index",[
      'sale' => $sale,
      'hot'=>$hot,
      'tui'=>$tui,
      'all'=>$all,
      'count'=>$count,
      'pager'=>$pager
    ]);
  }

  /**
   * 商品详细信息
   */
  public function actionDetail(){
    //view/product/detail.php   商品详情页面
    $productid = Yii::$app->request->get("productid");
    $product = Product::find()->where('productid = :id',[':id' => $productid])->asArray()->one();
    $data['all'] = Product::find()->where('ison = "1"')->orderby('createtime desc')->limit(7)->all();
    return $this->render("detail",['product' =>$product,'data'=>$data]);
  }

    /**
     * 实现商品全文搜索
     * @return string
     */
  public function actionSearch(){

      $this->layout = "layout2";
      $keyword = htmlspecialchars(Yii::$app->request->get("keyword"));
      $highlight = [
          "pre_tags" => ["<em>"],
          "post_tags" => ["</em>"],
          "fields" => [
              "title" => new \stdClass(),
              "description" => new \stdClass()
          ]
      ];
      $searchModel = ProductSearch::find()->query([
          "multi_match" => [
              "query" => $keyword,
              "fields" => ["title", "description"]
          ],
      ])->all();
      var_dump($searchModel);die;

      /*
      $this->layout = "layout2";
      $keyword = htmlspecialchars(Yii::$app->request->get("keyword"));
      // Product::find()->where("title like '%$keyword%'");
      $highlight = [
          "pre_tags" => ["<em>"],
          "post_tags" => ["</em>"],
          "fields" => [
              "title" => new \stdClass(),
              "description" => new \stdClass()
          ]
      ];
      $searchModel = ProductSearch::find()->query([
          "multi_match" => [
              "query" => $keyword,
              "fields" => ["title", "description"]
          ],
      ]);
      $count = $searchModel->count();
      $pageSize = Yii::$app->params['pageSize']['frontproduct'];
      $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
      $res = $searchModel->highlight($highlight)->offset($pager->offset)->limit($pager->limit)->all();
      $products = [];
      foreach ($res as $result) {
          $product = Product::findOne($result->productid);
          $product->title = !empty($result->highlight['title'][0]) ? $result->highlight['title'][0] : $product->title;
          $product->description = !empty($result->highlight['description'][0]) ? $result->highlight['description'][0] : $product->description;
          $products[] = $product;
      }
      $model = Product::find();
      $where = "ison = '1'";
      $tui = $model->Where($where . ' and istui = \'1\'')->orderby('createtime desc')->limit(5)->asArray()->all();
      $hot = $model->Where($where . ' and ishot = \'1\'')->orderby('createtime desc')->limit(5)->asArray()->all();
      $sale = $model->Where($where . ' and issale = \'1\'')->orderby('createtime desc')->limit(5)->asArray()->all();
      return $this->render('index', ['sale' => $sale, 'tui' => $tui, 'hot' => $hot, 'all' => $products, 'pager' => $pager, 'count' => $count]);
      */
  }
}



