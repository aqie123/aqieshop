<?php

namespace app\modules\controllers;
use app\models\Order;
use app\models\OrderDetail;
use app\models\Product;
use app\models\User;
use app\models\Address;
use yii\web\Controller;
use yii\data\Pagination;
use Yii;
use app\modules\controllers\CommonController;

class OrderController extends CommonController
{
  protected $mustlogin = ['list', 'detail', 'send'];
  public function actionList()     // 订单列表
  {
    $this->layout = "layout1";
    $model = Order::find();
    $count = $model->count();
    $pageSize = Yii::$app->params['pageSize']['order'];
    $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
    $data = $model->offset($pager->offset)->limit($pager->limit)->all();
    $data = Order::getDetail($data);
    return $this->render('list',['pager' => $pager, 'orders' => $data]);

  }

  public function actionDetail()  // 订单详情
  {
    $this->layout = "layout1";
    $orderid = (int)Yii::$app->request->get('orderid');
    $order = Order::find()->where('orderid = :oid', [':oid' => $orderid])->one();
    $data = Order::getData($order);
    return $this->render('detail', ['order' => $data]);
  }

  public function actionSend()   // 发货
  {
    $this->layout = "layout1";
    $orderid = (int)Yii::$app->request->get('orderid');
    $model = Order::find()->where('orderid = :oid', [':oid' => $orderid])->one();
    $model->scenario = "send";
    if(Yii::$app->request->isPost) {
      $post = Yii::$app->request->post();    // 拿到post数组
      $model->status = Order::SENDEND;
      if($model->load($post) && $model->save()) {
        Yii::$app->session->setFlash('info','发货成功');
      }
    }
    $model->expressno = '';
    return $this->render('send',['model'=>$model]);
  }
}