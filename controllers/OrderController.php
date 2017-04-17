<?php 
namespace app\controllers;
use app\controllers\CommonController;
use Yii;
use app\models\Order;
use app\models\OrderDetail;
use app\models\Cart;
use app\models\Product;
use app\models\User;
use app\models\Address;
use app\models\Pay;
use dzer\express\Express;


class OrderController extends CommonController        //　前台controller
{
  public $layout = "layout2";
  public function actionCheck(){          // 查询该用户地址信息,该订单下订单详情，快递信息
    if(Yii::$app->session['isLogin']!=1){
      return $this->render('member/auth');
    }
    $orderid = Yii::$app->request->get('orderid');
    $status = Order::find()->where('orderid =:oid',[':oid'=>$orderid])->one()->status;
    if($status != Order::CREATEORDER && $status != Order::CHECKORDER) {
      return $this->redirect(['order/index']);    // 跳回到订单列表，不进入收银台页面
    }
    $loginname = Yii::$app->session['loginname'];
    $userid = User::find()->where('username = :name or useremail = :email',[':name'=>$loginname,':email'=>$loginname])->one()->userid;
    $addresses = Address::find()->where('userid=:uid',[':uid'=>$userid])->asArray()->all();
    $details = OrderDetail::find()->where('orderid = :oid',[':oid'=>$orderid])->asArray()->all();
    $data = [];  //发送数据
    foreach($details as $detail) {
      $model =Product::find()->where('productid = :pid',[':pid' => $detail['productid']])->one();
      $detail['title'] = $model->title;
      $detail['cover'] = $model->cover;
      $data[] = $detail;
    }
    $express = Yii::$app->params['express'];
    $expressPrice = Yii::$app->params['expressPrice'];
    return $this->render("check",[
      'express' => $express,
      'expressPrice'=> $expressPrice,
      'addresses' =>$addresses,
      'products' =>$data,
    ]);
  }

  public function actionIndex(){     // 前台显示用户订单信息
    if (Yii::$app->session['isLogin'] != 1) {
        return $this->redirect(['member/auth']);
    }
    $loginname = Yii::$app->session['loginname'];
    $userid = User::find()->where('username = :name or useremail = :email', [':name' => $loginname, ':email' => $loginname])->one()->userid;
    $orders = Order::getProducts($userid);
    return $this->render("index", ['orders' => $orders]);
  }

  public function actionAdd()    // 订单添加
  {
    if(Yii::$app->session['isLogin']!=1){
      return $this->render('member/auth');
    }
    // 使用事务处理
    $transaction = Yii::$app->db->beginTransaction();
    try {
      //向order表添加数据
      if(Yii::$app->request->isPost){
        $post = Yii::$app->request->post();
        $ordermodel = new Order;
        $ordermodel->scenario = 'add';
        $loginname = Yii::$app->session['loginname'];
        // $loginemail = Yii::$app->session['loginname'];
        $usermodel = User::find()->where('username = :name or useremail = :email' ,[':name'=>$loginname,':email'=>$loginname])->one();
        if(!$usermodel) {
          throw new \Exception();
        }
        $userid= $usermodel->userid; // 获取用户id      // 向order添加数据
        $ordermodel->userid = $userid;
        $ordermodel->status = Order::CREATEORDER;
        $ordermodel->createtime = time();
        if(!$ordermodel->save()) {
          throw new \Exception();
        }
        $orderid = $ordermodel->getPrimaryKey();
        //向orderdetail添加数据
        foreach($post['OrderDetail'] as $product){    //向order_detail添加数据
          $model = new OrderDetail;
          $product['orderid'] = $orderid;   //添加的主键id
          $product['createtime'] = time();
          $data['OrderDetail'] = $product;
          if(!$model->add($data)){    //写入失败
            throw new \Exception();
          }
          // 清空购物车
          Cart::deleteAll('productid = :pid',[':pid'=>$product['productid']]);
          //商品库存更新
          Product::updateAllCounters(['num'=> -$product['productnum']],'productid = :pid',[':pid'=>$product['productid']]);
        }
      }
      $transaction->commit();   // 没有异常执行
    } catch(\Exception $e) {
      $transaction->rollback();
      return $this->redirect(['cart/index']);
    }
    return $this->redirect(['order/check','orderid'=>$orderid]);
  }

  // 点击提交订单,传递orderid(post),addressid(post),hidden|expressid(post)
  // 确认订单 更新字段 addressid,expressid,status,amount(orderid.userid作为条件)
  public function actionConfirm()  
  {
    try{
      if (Yii::$app->session['isLogin']!=1) {
        return $this->render('member/auth');
      }

      if (!Yii::$app->request->isPost) {  // 只接受post
          throw new \Exception();
      }
      $post = Yii::$app->request->post();
      $loginname = Yii::$app->session['loginname'];
      $usermodel = User::find()->where('username = :name or useremail = :email',[':name' => $loginname,':email'=>$loginname])->one();
      if(empty($usermodel)){        // 如果用户不存在
        throw new \Exception();
      }
      $userid = $usermodel->userid;
      $model = Order::find()->where('orderid =:oid and userid = :uid',[':oid'=>$post['orderid'],':uid'=>$userid])->one();
      if(empty($model)) {
        throw new \Exception();
      }
      $model->scenario = "update";    // 定义场景update
      // 更新字段
      $post['status'] = Order::CHECKORDER;
      $details = OrderDetail::find()->where('orderid = :oid',[':oid'=>$post['orderid']])->all();
      $amount = 0;
      foreach($details as $detail){
        $amount += $detail->productnum*$detail->price;
      }
      if($amount <= 0){
        throw new \Exception();
      }
      $express = Yii::$app->params['expressPrice'][$post['expressid']];
      if($express <0){
        throw new \Exception();
      }
      $amount += $express;
      $post['amount'] = $amount;
      // 把post数据写入   更新shop_order这张表
      $data['Order'] = $post;
      // if (empty($post['addressid'])) {
      //   return $this->redirect(['order/pay', 'orderid' => $post['orderid'], 'paymethod' => $post['paymethod']]);
      // }
      if($model->load($data) && $model->save()){  // 更新数据成功
        return $this->redirect(['order/pay','orderid'=>$post['orderid'],'paymethod'=>$post['paymethod']]);              // 跳转到支付页面
      }
    }catch(\Exception $e){}
    return $this->redirect(['index/index']);   // 有错跳转回首页      
  }

  public function actionPay()   //跳转到支付网关
  {
    try{
      if (Yii::$app->session['isLogin'] != 1) {
          throw new \Exception();
      }
      $orderid = Yii::$app->request->get('orderid');
      $paymethod = Yii::$app->request->get('paymethod');
      if(empty($orderid) || empty($paymethod)){
        throw new \Exception();
      }

      if($paymethod == 'alipay') {
        return Pay::alipay($orderid);
      }
    }catch(\Exception $e){}
    return $this->redirect(['order/index']);  // 跳回到订单首页
  }


  public function actionGetexpress()   // 获取物流信息
  {
    $expressno = Yii::$app->request->get('expressno');
    $res = Express::search($expressno);
    echo $res;
    exit;
  }


  public function actionReceived()   // 点击确认收货
  {
    $orderid = Yii::$app->request->get('orderid');
    $order = Order::find()->where('orderid = :oid',[':oid'=>$orderid])->one();
    if(!empty($order) && $order->status == Order::SENDEND){
      $order->status = Order::RECEIVED;
      $order->save();
    }
    return $this->redirect(['order/index']);
  }

}




