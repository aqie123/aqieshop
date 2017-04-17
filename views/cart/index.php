<?php use yii\bootstrap\ActiveForm;
$this->title = "购物车";
?>


</header>
<!-- ============================================================= HEADER : END ============================================================= -->  
<?php $form = ActiveForm::begin([
    'action' => yii\helpers\Url::to(['order/add']),
]); ?>
 <section id="cart-page">
    <div class="container">
        <!-- ========================================= CONTENT ========================================= -->
        
        <div class="col-xs-12 col-md-9 items-holder no-margin" id="aqie">
            <?php $total = 0; ?>
            <?php foreach((array)$data as $k=>$product): ?>
            <input type="hidden" name="OrderDetail[<?php echo $k; ?>][productid]" value = "<?php echo $product['productid']; ?>">
            <input type="hidden" name="OrderDetail[<?php echo $k; ?>][price]" value="<?php echo $product['price']; ?>">
            <input type="hidden" name="OrderDetail[<?php echo $k; ?>][productnum]" value="<?php echo $product['productnum']; ?>">
            <div class="row no-margin cart-item">         
                <div class="col-xs-12 col-sm-2 no-margin">
                    <a href="<?php echo yii\helpers\Url::to(['product/detail', 'productid' => $product['productid']]); ?>" class="thumb-holder">
                        <img class="lazy" alt="" src="<?php echo $product['cover']; ?>-picsmall" />
                    </a>
                </div>

                <div class="col-xs-12 col-sm-5 ">
                    <div class="title">
                        <a href="<?php echo yii\helpers\Url::to(['product/detail', 'productid' => $product['productid']]); ?>"><?php echo $product['title']; ?></a>
                    </div>
                    <div class="brand">aqie</div>
                </div> 

                <div class="col-xs-12 col-sm-3 no-margin">
                    <div class="quantity">
                        <div class="le-quantity productnum">
                            <form>
                                <a class="minus minu" href="javascript:;" disabled = "disabled"></a>
                                    <!-- 购物车商品数量 -->
                                    <input id="<?php echo $product['cartid']; ?>" name="productnum" readonly="readonly" type="text" value="<?php echo $product['productnum']; ?>"  />
                                <a class="plus plu" href="javascript:;"></a>
                            </form>
                        </div>
                    </div>  
                </div> 

                <div class="col-xs-12 col-sm-2 no-margin">
                    <div class="price">
                        ￥<span><?php echo $product['price']; ?></span>
                    </div>
                    <a class="close-btn" href="<?php echo yii\helpers\Url::to(['cart/del', 'cartid' => $product['cartid']]); ?>"></a>  
                </div>
            </div><!-- /.cart-item -->
            <?php $total += $product['price']*$product['productnum']; ?>
            <?php endforeach; ?>
        </div>
        <!-- ========================================= CONTENT : END ========================================= -->

        <!-- ========================================= SIDEBAR ========================================= -->

        <div class="col-xs-12 col-md-3 no-margin sidebar ">
            <div class="widget cart-summary">
                <h1 class="border">商品购物车</h1>
                <div class="body">
                    <ul class="tabled-data no-border inverse-bold">
                        <li>
                            <label>商品总价</label>
                            <div class="value pull-right">￥<span><?php echo $total; ?></span></div>
                        </li>
                        <li>
                            <label>运费</label>
                            <div class="value pull-right">free shipping</div>
                        </li>
                    </ul>
                    <ul id="total-price" class="tabled-data inverse-bold no-border">
                        <li>
                            <label>订单总价</label>
                            <div class="value pull-right">￥<span><?php echo $total; ?></span></div>
                        </li>
                    </ul>
                    <div class="buttons-holder">
                        <input type="submit" name="" class="le-button big" value="结算">
                        <a class="simple-link block" href="<?php echo yii\helpers\Url::to(['index/index']); ?>" >继续购物</a>
                    </div>
                </div>
            </div><!-- /.widget -->

            <div id="cupon-widget" class="widget">
                <h1 class="border">使用优惠券</h1>
                <div class="body">
                    <form>
                        <div class="inline-input">
                            <input data-placeholder="请输入兑换码" type="text" />
                            <button class="le-button" type="submit">使用</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.widget -->
        </div><!-- /.sidebar -->

        <!-- ========================================= SIDEBAR : END ========================================= -->
    </div>
</section> 
<?php ActiveForm::end(); ?>
<!-- ============================================================= FOOTER ============================================================= -->

<?php
    $url = yii\helpers\Url::to(['cart/mod']);
    $js = <<<JS
    // 购物车数据绑定
    
    $('.productnum a').click(function(e){
      e.preventDefault();
      //alert("购物车页面")
      var cartid = $(this).parent().find("input").attr('id');
        // alert(cartid);
        var num = $(this).parent().find("input").val();
        // alert(num);
        var total = parseFloat($(".value.pull-right span").html());
        var price = parseFloat($(this).closest('.cart-item').find('.price span').html());
        if( $(this).hasClass('minu') && num>1){
            $(this).parent().find('input').val(parseInt(num, 10) - 1);
            num--;
            var p = total -price;
        }else if( $(this).hasClass('plu')){
            $(this).parent().find('input').val(parseInt(num, 10) + 1);
            num++;
            var p = total +price; 
        }else{
          var p = total;
           num =1;  
        }

        //alert(num);
        // alert(price)
        // alert(p)
        changeNum(cartid,num);
        $(".value.pull-right span").html(p + "");
        $(".value.pull-right.ordertotal span").html(p + "");
      });

    function changeNum(cartid,num){
      $.get('$url',{'productnum':num,'cartid':cartid},function(data){
          // location.reload();
        });
    }
JS;
$this->registerJs($js);




