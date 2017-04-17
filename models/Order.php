<?php 
namespace app\models;
use yii\db\ActiveRecord;
use app\models\OrderDetail;
use app\models\Product;
use app\models\Category;

class Order extends ActiveRecord
{
  const CREATEORDER = 0;
  const CHECKORDER = 100;   //待支付
  const PAYFAILED = 201;
  const PAYSUCCESS = 202;
  const SENDEND = 220;     // 发货成功   
  const RECEIVED = 260;    //收货成功

  public static $status = [
    self::CREATEORDER => '订单初始化',
    self::CHECKORDER =>'待支付',
    self::PAYFAILED =>'支付失败',
    self::PAYSUCCESS =>'等待发货',
    self::SENDEND => '已发货',
    self::RECEIVED =>'订单完成',
  ];

  public $products;   // 存储该订单里面所有商品列表
  public $zhstatus;   //中文状态说明
  public $username;    //用户名
  public $address;     // 收货地址

  public function rules()
  {
    return [
      [['userid','status'],'required','on'=>['add']],
      [['addressid','expressid','amount','status'],'required','on'=>['update']],
      ['expressno','required','message' =>'请输入快递单号','on'=>'send'],
      ['crestetime','safe','on'=>['add']],
    ];
  }

  public static function tableName()
  {
    return "{{%order}}";
  }

  public function attributeLabels()
  {
    return [
      'expressno' => '快递单号',
    ];
  }

  public static function getDetail($orders)    // 后台获取订单详细信息
  {
    foreach($orders as $order){
        $order = self::getData($order);
    }
    return $orders;
  }

  public static function getData($order)   
  {
    $details = OrderDetail::find()->where('orderid = :oid',[':oid'=>$order->orderid])->all();
    $products = [];
    foreach($details as $detail) {
      // 商品对象
      $product = Product::find()->where('productid = :pid',[':pid'=>$detail->productid])->one();
      if(empty($product)) {
        continue;
      }
      $product->num = $detail->productnum;   // 购买的商品数量
      $products[] = $product;               // 存储进数组
    }
    $order->products = $products;          //存储进属性
    $user = User::find()->where('userid = :uid',[':uid'=>$order->userid])->one();  
    // 通过用户id获取username
    if(!empty($user)){
      $order->username = $user->username;    // 存储username
    }
    $order->address = Address::find()->where('addressid = :aid',[':aid'=>$order->addressid])->one();
    if(empty($order->address)) {
      $order->address = "";
    }else {
      $order->address = $order->address->address;   // 地址
    }
    $order->zhstatus = self::$status[$order->status];   //中文状态(上面中文说明)
    return $order;
  }

  public static function getProducts($userid)    //前台获取产品信息
  {
    $orders = self::find()->where('status > 0 and userid = :uid', [':uid' => $userid])->orderBy('createtime desc')->all();
    foreach($orders as $order) {
        $details = OrderDetail::find()->where('orderid = :oid', [':oid' => $order->orderid])->all();
        $products = [];
        foreach($details as $detail) {
            $product = Product::find()->where('productid = :pid', [':pid' => $detail->productid])->one();
            if (empty($product)) {
                continue;
            }
            $product->num = $detail->productnum;
            $product->price = $detail->price;
            $product->cate = Category::find()->where('cateid = :cid', [':cid' => $product->cateid])->one()->title;
            $products[] = $product;
        }
        $order->zhstatus = self::$status[$order->status];
        $order->products = $products;
    }
    return $orders;
  }
}




