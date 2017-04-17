<?php
namespace app\controllers;
use app\controllers\CommonController;

use Yii;
use app\models\User;
use app\models\Address;

class AddressController extends CommonController
{
  protected $mustlogin = ['del', 'add'];
  public function actionAdd()    // 添加收货地址
  {
    $userid = Yii::$app->user->id;
    if (Yii::$app->request->isPost) {
        $post = Yii::$app->request->post();
        $post['userid'] = $userid;
        $post['address'] = $post['address1'].$post['address2'];
        $data['Address'] = $post;
        $model = new Address;
        $model->load($data);
        $model->save();
    }
    return $this->redirect($_SERVER['HTTP_REFERER']);   // 跳回刚才地址
        
  }

  public function actionDel()   // 删除收货地址
  {
    $userid = Yii::$app->user->id;
    $addressid = Yii::$app->request->get('addressid');
    if (!Address::find()->where('userid = :uid and addressid = :aid', [':uid' => $userid, ':aid' => $addressid])->one()) {
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
    Address::deleteAll('addressid = :aid', [':aid' => $addressid]);
    return $this->redirect($_SERVER['HTTP_REFERER']);
  }
}