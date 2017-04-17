<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$this->title = '订单列表';
$this->params['breadcrumbs'][] = ['label' => '订单管理', 'url' => ['/admin/order/list']];
$this->params['breadcrumbs'][] = $this->title;
?>
  <!-- main container -->
      
        <div class="container-fluid">
            <div id="pad-wrapper" class="users-list">
                <div class="row-fluid header">
                    <h3>订单列表</h3>
                    <div class="span10 pull-right">
                        <input type="text" class="span5 search" placeholder="Type a user's name..." />
                        
                        <!-- custom popup filter -->
                        <!-- styles are located in css/elements.css -->
                        <!-- script that enables this dropdown is located in js/theme.js -->
                        <div class="ui-dropdown">
                            <div class="head" data-toggle="tooltip" title="Click me!">
                                Filter users
                                <i class="arrow-down"></i>
                            </div>  
                            <div class="dialog">
                                <div class="pointer">
                                    <div class="arrow"></div>
                                    <div class="arrow_border"></div>
                                </div>
                                <div class="body">
                                    <p class="title">
                                        Show users where:
                                    </p>
                                    <div class="form">
                                        <select>
                                            <option />Name
                                            <option />Email
                                            <option />Number of orders
                                            <option />Signed up
                                            <option />Last seen
                                        </select>
                                        <select>
                                            <option />is equal to
                                            <option />is not equal to
                                            <option />is greater than
                                            <option />starts with
                                            <option />contains
                                        </select>
                                        <input type="text" />
                                        <a class="btn-flat small">Add filter</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users table -->
                <div class="row-fluid table">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="span2 sortable">
                                    <span class="line"></span>订单编号
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>下单人
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>收货地址
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>快递方式
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>订单总价
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>商品列表
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>订单状态
                                </th>
                                <th class="span3 sortable align-right">
                                    <span class="line"></span>操作
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <!-- row -->
                        <?php foreach($orders as $order): ?> 
                        <tr class="first">
                            <td>
                                <?php echo $order->orderid; ?>
                            </td>
                            <td>
                                <?php echo $order->username; ?>
                            </td>
                            <td>
                                <?php echo $order->address; ?>
                            </td>
                            <td>
                                <?php 
                                    if(array_key_exists($order->expressid, \Yii::$app->params['express'])){
                                        echo \Yii::$app->params['express'][$order->expressid];
                                    }
                                ?>
                            </td>
                            <td>
                                <?php echo $order->amount; ?>
                            </td>
                            <td>
                                <?php foreach($order->products as $product): ?>
                                    <?php echo $product->num ?> x <a href="<?php echo yii\helpers\Url::to(['/product/detail', 'productid' => $product->productid]) ?>"><?php echo $product->title ?></a>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <?php 
                                    if (in_array($order->status, [0])) {
                                        $info = "error";
                                    }

                                    if (in_array($order->status, [100,202])) {
                                        $info = "info";
                                    }
                                    
                                    if (in_array($order->status, [201])) {
                                        $info = "warning";
                                    }

                                    if (in_array($order->status, [220,260])) {
                                        $info = "success";
                                    }

                                ?>
                                <span class="label label-<?php echo $info ?>"> 
                                    <?php echo $order->zhstatus ?> 
                                </span>
                            </td>
                            <td class="align-right">
                                <?php if ($order->status == 100): ?>
                                <a href="<?php echo yii\helpers\Url::to(['order/send', 'orderid' => $order->orderid]) ?>">发货</a>
                                <?php endif; ?>
                                <a href="<?php echo yii\helpers\Url::to(['order/detail', 'orderid' => $order->orderid]) ?>">查看</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="pagination pull-right">
                    <?php echo yii\widgets\LinkPager::widget([
                        'pagination' => $pager,
                        'prevPageLabel' => '&#8249;',
                        'nextPageLabel' => '&#8250;',
                    ]); ?>
                </div>
                <!-- end users table -->
            </div>
        </div>

    <!-- end main container -->



