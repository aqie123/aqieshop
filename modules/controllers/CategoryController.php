<?php 

namespace app\modules\controllers;
use yii\web\Controller;
use Yii;
use app\models\Category;   // 导入Categorymodel
use app\modules\controllers\CommonController;
use yii\web\Response;

class CategoryController extends CommonController
{
    protected $mustlogin = ['tree', 'list', 'add', 'mod', 'del', 'rename', 'delete'];
    /**
     * 返回json格式数据，产品分类那里
     * @return array
     */
    public function actionTree()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new Category;
        $data = $model->getPrimaryCate();
        if (!empty($data)) {
            return $data['data'];
        }
        return [];

    }

    /**
     * 显示分类列表，同时分类
     * @return string
     */

  public function actionList()   // 任务：每页显示五个顶级分类，点击时候查询出所有子分类
  {
    $this->layout = "layout1";
    // 接收参数 页数
    $page = (int)Yii::$app->request->get("page") ? (int)Yii::$app->request->get("page") : 1;
      // 每页大小
    $perpage = (int)Yii::$app->request->get("per-page") ? (int)Yii::$app->request->get("per-page") : 10;
    $model = new Category();
//    $lists = $model->getTreeList();
      $data = $model->getPrimaryCate();
      // 返回分页 页数
    return $this->render("list",['pager'=>$data['pages'],"page"=>$page,"perpage"=>$perpage]);
  }




    /**
     * 添加商品
     * @return string
     */
  public function actionAdd()
  {
    $model = new Category(); 
    $list = $model->getOptions();   //商品分类
    
    $this->layout = "layout1";
    
    /*
    $cates = $model ->getData();      // 把数据读取出来
    $tree= $model->getTree($cates);
    var_dump($tree);exit;             // 打印出json数组
    $tree = $model ->setPrefix($tree);
    var_dump($tree);exit;               //加完前缀
    */
    // $list = array_merge([0=>'添加顶级分类'],$list);        这么写会出问题
    if(Yii::$app->request->isPost) {
      $post = Yii::$app->request->post();
      if($model->add($post)) {
        Yii::$app->session->setFlash('info','添加分类成功');
      }
    }
    $model->title='';
    // 数据传递给模板
    return $this->render("add",['list'=>$list,'model'=>$model]);
  }

    /**
     * 修改分类列表(被弃用)
     * @return string
     */
    /*
  public function actionMod()
  {
    $this->layout = "layout1";
    $cateid = Yii::$app->request->get("cateid");    // 从页面接收数据,拿到model对象
    $model = Category::find()->where('cateid=:id',[':id' => $cateid])->one();
    if(Yii::$app->request->isPost){
      $post = Yii::$app->request->post();
      if($model->load($post) && $model->save()) {
        Yii::$app->session->setFlash('info','修改成功');
      }
    }
    $list = $model->getOptions();
    return $this->render('add',['model'=>$model,'list'=>$list]);
  }
    */

    /**
     * 删除分类(弃用)
     * @return Response
     */
    /*
  public function actionDel()
  {
    try{
      $cateid = Yii::$app->request->get('cateid');
      if(empty($cateid)) {
        throw new \Exception('参数错误');
      }
      // 如果有子类不允许删除
      $data = Category::find()->where('parentid = :pid',[":pid"=>$cateid])->one();
      if($data){    // 有子类
        throw new \Exception('该分类下有子类,不允许删除');
      }
      if(!Category::deleteAll('cateid = :id',[':id'=>$cateid])) {
        throw new \Exception('删除失败');
      }
    }catch(\Exception $e) {
      Yii::$app->session->setFlash('info',$e->getMessage());
    }
    return $this->redirect(['category/list']);
  }
    */


    /**
     * jstree通过ajax修改分类名称
     * @return array
     * @throws \yii\web\MethodNotAllowedHttpException
     */
    public function actionRename()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        // 判断是否是ajax请求
        if (!Yii::$app->request->isAjax) {
            throw new \yii\web\MethodNotAllowedHttpException('Access Denied');
        }
        // 拿到post数据
        $post = Yii::$app->request->post();
        $newtext = $post['new'];
        $old = $post['old'];
        $id = (int)$post['id'];
        if (empty($newtext) || empty($id)) {
            return ['code' => -1, 'message' => '参数错误', 'data' => []];
        }
        if ($old == $newtext) {
            return ['code' => 0, 'message' => 'ok', 'data' => []];
        }
        $model = Category::findOne($id);
        // 定义场景
        $model->scenario = 'rename';
        $model->title = $newtext;
        // save方法修改
        if ($model->save()) {
            return ['code' => 0, 'message' => 'ok', 'data' => []];
        }
        return ['code' => 1, 'message' => '更新失败', 'data' => []];
    }

    /**
     * 删除商品分类代码
     * @return array  json格式
     * @throws \yii\web\MethodNotAllowedHttpException
     */
    public function actionDelete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->request->isAjax) {
            throw new \yii\web\MethodNotAllowedHttpException('Access Denied');
        }
        $id = (int)Yii::$app->request->get("id");
        if (empty($id)) {
            return ['code' => -1, 'message' => '参数错误', 'data' => []];
        }
        $cate = Category::findOne($id);
        if (empty($cate)) {
            return ['code' => -1, 'message' => '参数错误', 'data' => []];
        }
        $total = Category::find()->where("parentid = :pid", [":pid" => $id])->count();
        if ($total > 0) {
            return ['code' => 1, 'message' => '该分类下包含子类，不允许删除', 'data' => []];
        }
        if ($cate->delete()) {
            return ['code' => 0, 'message' => 'ok', 'data' => []];
        }
        return ['code' => 1, 'message' => '删除失败', 'data' => []];
    }


}


