<?php 
namespace app\modules\controllers;
use yii\web\Controller;
use app\modules\controllers\CommonController;
use app\models\picture;
use crazyfd\qiniu\Qiniu;
use Yii;
// 控制器名和文件夹名相同
class PicturesController extends CommonController  
{
  public function actionAdd()   // 添加图片
  {
    $this->layout = "layout1";
    $model = new Picture;
    if(Yii::$app->request->isPost){
      $post = Yii::$app->request->post();
      $pictures = $this->upload();
      if(!$pictures) {
        $model->addError('pictures','图片不能为空');
      }else{   //拿到图片后
        $post['Picture']['pictures'] = $pictures['pictures'];
      }
      if($pictures && $model->add($post)){   // 如果有图片并且图片添加  调用model里面add方法
        Yii::$app->session->setFlash('info','添加成功');

      }else{
        Yii::$app->session->setFlash('info','添加失败');
      }
    }
    return $this->render('picture',['model'=>$model]);
  }

  public function actionList()    // 显示图片
  {
    $this->layout = "layout1";
    $model = Picture::find()->all();    // 加限制条件就能选择不同id图片
    // $pictures = Picture::find()->asArray()->orderby('createtime desc')->one();
    return $this->render('list',['model'=>$model]);
  }

  private function upload()      // 上传图片
  {
    $qiniu = new Qiniu(Picture::AK,Picture::SK,Picture::DOMAIN,Picture::BUCKET);
    $pictures = [];
    foreach($_FILES['Picture']['tmp_name']['pictures'] as $k=>$file) {
      if($_FILES['Picture']['error']['pictures'][$k]>0) { // 有错误
        continue;       // 跳过本次循环
      }
      $key = uniqid();
      $qiniu->uploadFile($file,$key);
      $pictures[$key] = $qiniu->getLink($key);
    }
    return ['pictures'=>json_encode($pictures)];    // json格式化
  }

  public function actionRemovepic()    // 删除存在七牛的图片
  {
    $this->layout = false;
    $key = Yii::$app->request->get("key");
    $pictureid = Yii::$app->request->get("pictureid");
    $model = Picture::find()->where('pictureid =:pid',[':pid'=>$pictureid])->one();
    $qiniu = new Qiniu(Picture::AK,Picture::SK,Picture::DOMAIN,Picture::BUCKET);
    $qiniu->delete($key);
    $pictures = json_decode($model->pictures,true);
    unset($pictures[$key]);   // 这个函数
    Picture::updateAll(['pictures' => json_encode($pictures)], 'pictureid = :pid', [':pid' => $pictureid]);
    return $this->redirect(['pictures/add','pictureid'=>$pictureid]);
  }
  
}