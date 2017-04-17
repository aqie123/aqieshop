<style type="text/css">
  .top10{
    margin: 50px auto;
  }
</style>
<div class="container top10">
  <?php foreach($orders as $order): ?>
  <div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">订单详情</div>
    <div class="panel-body">
      <span><?php echo date('Y-m-d H:i:s', $order->createtime); ?></span>
       | 订单id: <span><?php echo $order->orderid; ?></span>
    </div>
    <!-- Table -->
    <div class="table-responsive">
      <table class="table table-hover table-striped">
        <tr>
          <!-- <th>产品ID</th> -->
          <th>产品名称</th>
          <th>图片</th>
          <th>产品分类</th>
          <th>产品数量</th>
          <th>产品单价</th>
          <th>总价(含运费)</th>
          <th>订单状态</th>
          <th>操作</th>
        </tr>
        <?php $i = 1; ?>
        <?php foreach($order->products as $product): ?>
        <tr>
          <!-- <td></td> -->
          <td><?php echo $product->title; ?></td>
          <td>
            <a href="<?php echo yii\helpers\Url::to(['product/detail', 'productid' => $product->productid]) ?>"  target="_blank">
                <img src="<?php echo $product->cover ?>-piclistsmall"  max-width:80px;">
            </a>
          </td>
          <td><?php echo $product->cate; ?></td>
          <td><?php echo $product->num; ?></td>
          <td><?php echo $product->price; ?></td>
          <?php if($i==1): ?>
          <td><?php echo $order->amount; ?></td>
          <td>
            <a class="tp-tag-a" href="<?php echo yii\helpers\Url::to(['order/check', 'orderid' => $order->orderid]) ?>">
              <?php echo $order->zhstatus; ?>
            </a>        
          </td>
          <td>
            <?php if ($order->status == 220): ?>
            <a class="tp-tag-a" href="<?php echo yii\helpers\Url::to(['order/received', 'orderid' => $order->orderid]) ?>" target="_blank">确认收货
            </a>
            <a data="<?php echo $order->expressno ?>" class="tp-tag-a express wuliu">
              <span class="trade-operate-text">
                查看物流
              </span>
              <div class="expressshow" style="overflow:auto;text-align:left;font-size:12px;width:200px;height:200px;position:absolute;border:1px solid #ccc;padding:15px;background-color:#eee">查询中...</div>
            </a>
            <?php endif; ?>
            <?php if ($order->status == 260): ?>
              评价
            <?php endif; ?>
          </td>
          <?php else: ?>
            <td></td>
            <td></td>
            <td></td>
          <?php endif; ?>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>

      </table>
    </div>
  </div>
<?php endforeach; ?>
</div>