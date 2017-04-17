<?php

namespace  app\controllers;
use yii\web\Controller;
use app\models\Category;
use app\models\Product;
use app\models\User;
use app\models\Cart;

use Yii;
class CommonController extends Controller
{
    // 用户登录验证所有方法
    protected $actions = ['*'];
    protected $except = [];
    protected $mustlogin = [];
    protected $verbs = [];
  public function behaviors()
    {
        return [
            // 访问行为
            'access' => [
                'class' => \yii\filters\AccessControl::className(),

                'only' => $this->actions,       //  对哪些方法验证
                'except' => $this->except,      // 不对哪些方法验证
                'rules' => [
                    [
                        'allow' => false,
                        'actions' => empty($this->mustlogin) ? [] : $this->mustlogin,  // 方法名称 不能访问的方法
                        'roles' => ['?'], // guest 未登录用户
                    ],
                    [
                        'allow' => true,
                        'actions' => empty($this->mustlogin) ? [] : $this->mustlogin, //
                        'roles' => ['@'], // 登陆后可以访问
                    ],
                ],
            ],
            // 过滤器来控制只允许post或者get
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => $this->verbs,
            ],
        ];
    }

    /**
     * 调用控制器下方法,先自动调用init方法
     */
  public function init()
  {
      // 前台菜单缓存 首页导航查询所有菜单
      $cache = Yii::$app->cache;
      $key = 'menu';        // 指定key进行缓存
      //没有数据进行缓存,有数据直接读取
      if(!$menu = $cache->get($key)){
          $menu = Category::getMenu();      // 数据库查询
//          var_dump($menu);die;
          $cache->set($key,$menu,3600*2);
      }

    $this->view->params['menu'] = $menu;

      // 购物车数据缓存
      $key = "cart";    // 指定key
    if(!$data = $cache->get($key)){     // 从缓存中获取不到数据
        $data = [];
        $data['products']=[];
        $total = 0;

        $userid = Yii::$app->user->id;

        $carts = Cart::find()->where('userid = :uid',[':uid'=>$userid])->asArray()->all();
        foreach($carts as $k=>$pro){
          $product = Product::find()->where('productid=:pid',[':pid'=>$pro['productid']])->one();
          $data['products'][$k]['cover'] = $product->cover;
          $data['products'][$k]['title'] = $product->title;
          $data['products'][$k]['productnum'] = $pro['productnum'];
          $data['products'][$k]['price'] = $pro['price'];
          $data['products'][$k]['productid'] = $pro['productid'];
          $data['products'][$k]['cartid'] = $pro['cartid'];
          $total += $data['products'][$k]['price']*$data['products'][$k]['productnum'];

        }

        $data['total'] = $total;
        // 缓存依赖
        $dep = new \yii\caching\DbDependency([
            'sql' => 'select max(updatetime) from {{%cart}} where userid = :uid',
            'params' => [':uid' => Yii::$app->user->id],
        ]);
        $cache->set($key, $data, 60, $dep);
    }
    $this->view->params['cart']=$data;

    // 模板中查询四种分类商品
      // 对商品做查询缓存
      $dep = new \yii\caching\DbDependency([
          'sql' => 'select max(updatetime) from {{%product}} where ison = "1"',
      ]);   // 依赖就是查询更新时候,缓存也会更新
      $tui = Product::getDb()->cache(function (){
          return Product::find()
              ->where('istui = "1" and ison = "1"')
              ->orderby('createtime desc')
              ->limit(3)->all();
      }, 60, $dep);
      $new = Product::getDb()->cache(function(){
          return Product::find()
              ->where('ison = "1"')
              ->orderby('createtime desc')
              ->limit(3)->all();
      }, 60, $dep);
      $hot = Product::getDb()->cache(function(){
          return Product::find()
              ->where('ison = "1" and ishot = "1"')
              ->orderby('createtime desc')
              ->limit(3)->all();
      }, 60, $dep);
      $sale = Product::getDb()->cache(function(){
          return Product::find()
              ->where('ison = "1" and issale = "1"')
              ->orderby('createtime desc')
              ->limit(3)->all();
      }, 60, $dep);  ;
    $this->view->params['tui'] = (array)$tui;
    $this->view->params['new'] = (array)$new;
    $this->view->params['hot'] = (array)$hot;
    $this->view->params['sale'] = (array)$sale;

    // 在layouts显示  查询父级所有分类
      $category = Category::getDb()->cache(function(){
          return Category::find()
              ->where('parentid = "0"')
              ->orderby('createtime desc')
              ->limit(8)->all();
      }, 60, $dep);
    //$category = Category::find()->where('parentid = "0"')->orderby('createtime desc')->all();
    $this->view->params['category'] = (array)$category;
  }
}