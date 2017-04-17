<?php use yii\bootstrap\ActiveForm; ?>
</header>
<!-- ============================================================= HEADER : END ============================================================= -->   <!-- ========================================= CONTENT ========================================= -->
<style type="text/css">
    .field-row input[type="radio"] {
        width:30px;
    }
</style>
<section id="checkout-page">
    <div class="container">
        <div class="col-xs-12 no-margin">
            <section id="shipping-address" style="margin-bottom:50px;margin-top:-10px">
                <h2 class="border h1">收货地址</h2>
                <a href="#" id="createlink">新建联系人</a>
                <?php foreach($addresses as $key =>$address): ?>
                    <div class="row field-row">
                        <div class="col-xs-12">
                            <input  class="le-checkbox big address" type="radio" name="address" value="<?php echo $address['addressid']; ?>" <?php if ($key == 0) {echo 'checked = "checked"';}?> />
                            <a class="simple-link bold" href="#"><?php echo $address['lastname'].$address['firstname']."　".$address['email']."　".$address['telephone']; ?></a>
                            <a style="margin-left:45px" href="<?php echo yii\helpers\Url::to(['address/del', 'addressid' => $address['addressid']]) ?>">删除</a>
                        </div>
                    </div><!-- /.field-row -->
                <?php endforeach; ?>
            </section><!-- /#shipping-address -->

            <div class="billing-address" style="display:none;">
                <h2 class="border h1">新建联系人</h2>
                    <?php ActiveForm::begin([
                        'action'=>['address/add'],
                    ]) ?>
                    <div class="row field-row">
                        <div class="col-xs-12 col-sm-6">
                            <label>姓</label>
                            <input class="le-input" name="lastname">
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <label>名</label>
                            <input class="le-input" name="firstname">
                        </div>
                    </div><!-- /.field-row -->

                    <div class="row field-row">
                        <div class="col-xs-12">
                            <label>公司名称</label>
                            <input class="le-input" name="company">
                        </div>
                    </div><!-- /.field-row -->

                    <div class="row field-row">
                        <div class="col-xs-12 col-sm-6">
                            <label>地址</label>
                            <input class="le-input" data-placeholder="例如：北京市朝阳区" name="address1">
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <label>&nbsp;</label>
                            <input class="le-input" data-placeholder="例如：酒仙桥北路" name="address2">
                        </div>
                    </div><!-- /.field-row -->

                    <div class="row field-row">
                        <div class="col-xs-12 col-sm-4">
                            <label>邮编</label>
                            <input class="le-input"  name="postcode">
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <label>邮箱地址</label>
                            <input class="le-input" name="email">
                        </div>

                        <div class="col-xs-12 col-sm-4">
                            <label>联系电话</label>
                            <input class="le-input" name="telephone">
                        </div>
                    </div><!-- /.field-row -->

                    <!-- <div class="row field-row">
                        <div id="create-account" class="col-xs-12">
                            <input  class="le-checkbox big" type="checkbox"  />
                            <a class="simple-link bold" href="#">Create Account?</a> - you will receive email with temporary generated password after login you need to change it.
                        </div>
                    </div> -->
                    <div class="place-order-button">
                        <button class="le-button small">新建</button>
                    </div><!-- /.place-order-button -->
                <?php ActiveForm::end(); ?>
            </div><!-- /.billing-address -->
 
            <?php ActiveForm::begin([
                'action' => ['order/confirm'],
                'options'=> ['id' => 'orderconfirm'],
            ]); ?>
            <section id="your-order">
                <h2 class="border h1">您的订单</h2>
                    <?php  $total = 0; ?>   
                    <?php foreach($products as $product): ?>
                    <div class="row no-margin order-item">
                        <div class="col-xs-12 col-sm-1 no-margin">
                            <a href="<?php echo yii\helpers\Url::to(['product/detail', 'productid' => $product['productid']]) ?>" class="qty"><?php echo $product['productnum']; ?> </a>
                        </div>

                        <div class="col-xs-12 col-sm-9 ">
                            <div class="title">
                                <a href="<?php echo yii\helpers\Url::to(['product/detail', 'productid' => $product['productid']]); ?>" class="thumb-holder">
                                    <img class="lazy" alt="" src="<?php echo $product['cover']; ?>-piclistsmall" />
                                </a>
                                <a style="margin-left:50px" href="<?php echo yii\helpers\Url::to(['product/detail', 'productid' => $product['productid']]); ?>"><?php echo $product['title']; ?> </a>
                            </div>
                            <div class="brand" style="margin-left:100px">aqie</div>
                        </div>

                        <div class="col-xs-12 col-sm-2 no-margin">
                            <div class="price">￥<?php echo $product['price'] ?></div>
                        </div>
                    </div><!-- /.order-item -->
                    <?php $total += $product['productnum']*$product['price']; ?>
                    <?php endforeach; ?>
                    
                
            </section><!-- /#your-order -->
            <!-- 传递购物地址id -->
            <input type="hidden" name="addressid" value="1">
            <div id="total-area" class="row no-margin">
                <div class="col-xs-12 col-lg-4 col-lg-offset-8 no-margin-right">
                    <div id="subtotal-holder">
                        <ul class="tabled-data inverse-bold no-border">
                            <li>
                                <label>商品总价</label>
                                <div class="value" id="total">￥<span><?php echo $total; ?></span></div>
                            </li>
                            <li>
                                <label>选择快递</label>
                                <div class="value">
                                    <div class="radio-group">
                                        <?php foreach($express as $k => $e): ?>
                                        <!-- <?php $checked = ""; if($k==1) $checked = "checked" ?> -->
                                        <input class="le-radio express" type="radio" name="expressid" value="<?php echo $k; ?>" data="<?php echo $expressPrice[$k]; ?>" <?php if ($k == 3) {echo 'checked = "checked"';}?> >
                                        <div class="radio-label bold">
                                            <?php echo $e; ?>
                                            <span>￥ <?php echo $expressPrice[$k] ?></span>        
                                        </div><br>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </li>
                        </ul><!-- /.tabled-data -->

                        <ul id="total-field" class="tabled-data inverse-bold ">
                            <li>
                                <label>订单总价tal</label>
                                <div class="value" id="ototal">￥<span><?php echo $total+20; ?></span></div>
                            </li>
                        </ul><!-- /.tabled-data -->

                    </div><!-- /#subtotal-holder -->
                </div><!-- /.col -->
            </div><!-- /#total-area -->
            
            <style type="text/css">
                .payment-method-option>input[name="paymethod"]{
                    width: 30px;
                }
            </style>
            <div id="payment-method-options">
                    <div class="payment-method-option">
                        <input class="le-radio" type="radio" name="paymethod" value="alipay" checked>
                        <div class="radio-label bold ">支付宝支付<br>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce rutrum tempus elit, vestibulum vestibulum erat ornare id.</p>
                        </div>
                    </div><!-- /.payment-method-option -->
            </div><!-- /#payment-method-options -->
            
            <div class="place-order-button">
                <button class="le-button big">确认订单</button>
            </div><!-- /.place-order-button -->

        </div><!-- /.col -->
    </div><!-- /.container -->    
</section><!-- /#checkout-page -->
<!-- ========================================= CONTENT : END ========================================= -->    <!-- ============================================================= FOOTER ============================================================= -->
<!-- 传递orderid -->
<input type="hidden" name="orderid" value="<?php echo (int)\Yii::$app->request->get("orderid"); ?>">
<?php ActiveForm::end(); ?>