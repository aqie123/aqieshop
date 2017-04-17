<?php

web    ：  web应用根目录
assets :   yii发布资源文件(css,js)
index  ：  应用入口文件
rentime:   运行生成文件(缓存,日志)
vendor :   已经安装composer(包含yii框架本身)
config :   应用配置及其他应用
commands:  控制台命令类
controllers: 控制器类
models  :    模型类


1,创建控制器类->indexController
  controllers/ 新建IndexController控制器
  类名要有Controller
  继承yii\web\Controller

  创建动作方法
  前缀要是action
  渲染模板使用render方法

3, 创建数据模型类  models/  
   继承 yii\db\ActiveRecord类
   声明tableName()指定表名
   使用{{%表名}}指定表前缀

// 简单查询
$model->find()->one()



4.将数据传递给模板
// (模板中变量名称,查询数据)
$this->render("index",array("data" => $data));


5,页头页尾设置在layout
views/layouts/布局文件




6.后台通过admin/default/index访问






7.改变默认控制器

8.分页处理
 1. 引入分页类：use yii\data\Pagination;
 2. $managers = Admin::find()->all();  查询所有数据
 3. $model= Admin::find();
    $count = $model->count();
9.
  相对路径页面跳转

 echo yii\helpers\Url::to(); 



10.表单是否提交，进行存储，验证，并返回信息
if(Yii::$app->request->isPost){
        $post = Yii::$app->request->post();
        if($model->changepass($post)){
          Yii::$app->session->setFlash("info","修改密码成功");
        }
}

CartController  购物车  模板2
IndexController index 前台首页 模板1 
MemberController 登录注册页面 模板2
OrderController index 订单页面 check 收货地址 模板2
ProductController index 商品列表  detail 商品详情页 模板2

2.16
1. 前台 遍历前台首页分类
        遍历前台首页商品
2. 点击分类进入product/index 商品列表(推荐商品,特价商品,热卖)商品打折力度,标题，原价，促销价，对否推荐
3.商品详情页 product/detail (商品封面,商品图片列表)


 foreach($data['tui'] as $pro): 
                        <div class="col-sm-4 col-md-3  no-margin product-item-holder hover">
                            <div class="product-item">
                                <div class="ribbon red"><span>促销</span></div> 
                                <div class="ribbon blue"><span>new!</span></div> 
                                <div class="ribbon green"><span>hot!</span></div> 

?>
<?php if($pro->isnew): ?>
<div class="ribbon blue"><span>new!</span></div> 
<?php endif; ?>
<?php 
  $datas = Product::find()->where(...)->all();
  // 然后在页面
  foreach ($datas as $data):
  endforeach; 
 ?>

 $this->view->params 在layouts里面可以使用

 购物车

 存储商品(保存商品id)
 商品单价
 商品数量
 用户id




 订单设计
 1. 结算->创建订单(用户,订单状态,商品信息,下单时间)
 2.展示商品信息
 3.确认订单(收货地址,快递方式,订单总价,更新状态)
 4.支付成功
 5.后台管理发货
 6.用户确认收货
 7.更新订单状态

 两张数据表
 (order)订单表：下单人,商品,订单总价,订单状态,快递方式,快递单号,收货地址,下单时间,更新时间

 (orderdetail)订单详情： 下单商品id,商品价格,商品数量,订单号

 (address)收货地址：姓名，公司，详细地址，邮编，邮件地址，电话，用户id
 快递方式：快递名称，快递价格



order/confirm -> order/pay -> 支付网关 ->pay/return (显示支付状态)->notify.php(异步通知)->pay/notify(更新订单状态)


高并发

数据库优化






一：总结
1.忘记密码发送邮件
2，用户管理员管理，分页
3.无限分类
4.商品列表(图床)
5.前台下单，遍历显示->加入购物车->结算->支付->确认收货

加入购物车通过队列
搜索








