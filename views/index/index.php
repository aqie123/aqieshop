
<!-- ============================================================= HEADER : END ============================================================= --> 
<div id="top-banner-and-menu">
  <div class="container">

    <div class="col-xs-12 col-sm-4 col-md-3 sidemenu-holder">
      <!-- ================================== TOP NAVIGATION ================================== -->
      <div class="side-menu animate-dropdown">
        <div class="head"><i class="fa fa-list"></i>所有分类</div>        
        <nav class="yamm megamenu-horizontal" role="navigation">
            <ul class="nav">
                <li class="dropdown menu-item">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">导航</a>
                    <ul class="dropdown-menu mega-menu">
                        <li class="yamm-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <ul class="list-unstyled">
                                        <li><a href="index.html">首页</a></li>
                                        <li><a href="index-2.html">Home Alt</a></li>
                                        <li><a href="category-grid.html">Category - Grid/List</a></li>
                                        <li><a href="category-grid-2.html">Category 2 - Grid/List</a></li>
                                        <li><a href="single-product.html">Single Product</a></li>
                                        <li><a href="single-product-sidebar.html">Single Product with Sidebar</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <ul class="list-unstyled">
                                        <li><a href="cart.html">Shopping Cart</a></li>
                                        <li><a href="checkout.html">Checkout</a></li>
                                        <li><a href="about.html">About Us</a></li>
                                        <li><a href="contact.html">Contact Us</a></li>
                                        <li><a href="blog.html">Blog</a></li>
                                        <li><a href="blog-fullwidth.html">Blog Full Width</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <ul class="list-unstyled">
                                        <li><a href="blog-post.html">Blog Post</a></li>
                                        <li><a href="faq.html">FAQ</a></li>
                                        <li><a href="terms.html">Terms & Conditions</a></li>
                                        <li><a href="authentication.html">Login/Register</a></li><li><a href="http://www.moke8.com">More</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>

                    </ul>
                </li><!-- /.menu-item -->
                <li class="dropdown menu-item">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">今日推荐</a>
                    <ul class="dropdown-menu mega-menu">
                        <li class="yamm-content">
                            <!-- ================================== MEGAMENU VERTICAL ================================== -->
                            <div class="row">
                                <div class="col-xs-12 col-lg-4">
                                    <ul>
                                        <li><a href="#">Computer Cases &amp; Accessories</a></li>
                                        <li><a href="#">CPUs, Processors</a></li>
                                        <li><a href="#">Fans, Heatsinks &amp; Cooling</a></li>
                                        <li><a href="#">Graphics, Video Cards</a></li>
                                        <li><a href="#">Interface, Add-On Cards</a></li>
                                        <li><a href="#">Laptop Replacement Parts</a></li>
                                        <li><a href="#">Memory (RAM)</a></li>
                                        <li><a href="#">Motherboards</a></li>
                                        <li><a href="#">Motherboard &amp; CPU Combos</a></li>
                                        <li><a href="#">Motherboard Components &amp; Accs</a></li>
                                    </ul>
                                </div>

                                <div class="col-xs-12 col-lg-4">
                                    <ul>
                                        <li><a href="#">Power Supplies Power</a></li>
                                        <li><a href="#">Power Supply Testers Sound</a></li>
                                        <li><a href="#">Sound Cards (Internal)</a></li>
                                        <li><a href="#">Video Capture &amp; TV Tuner Cards</a></li>
                                        <li><a href="#">Other</a></li>
                                    </ul>
                                </div>

                                <div class="dropdown-banner-holder">
                                    <a href="#"><img alt="" src="assets/images/banners/banner-side.png" /></a>
                                </div>
                            </div>
                            <!-- ================================== MEGAMENU VERTICAL ================================== -->                        
                        </li>
                    </ul>
                </li><!-- /.menu-item -->
                <?php 
                    foreach($this->params['menu'] as $top) :    // 循环遍历商品分类
                ?>
                <li class="dropdown menu-item">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $top['title'];?></a>
                    <ul class="dropdown-menu mega-menu">
                        <li class="yamm-content">
                            <!-- ================================== MEGAMENU VERTICAL ================================== -->
                            <div class="row">
                                <div class="col-xs-12 col-lg-4"><!-- 弹出层左侧 -->
                                    <ul>    
                                        <?php foreach($top['children'] as $child): ?>
                                        <li><a href="<?php echo yii\helpers\Url::to(['product/index','cateid'=>$child['cateid']]); ?>"><?php echo $child['title']; ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>

                                <div class="col-xs-12 col-lg-4"><!-- 弹出层右侧 -->
                                    <ul>
                                        <li><a href="#">Power Supplies Power</a></li>
                                        <li><a href="#">Power Supply Testers Sound</a></li>
                                        <li><a href="#">Sound Cards (Internal)</a></li>
                                        <li><a href="#">Video Capture &amp; TV Tuner Cards</a></li>
                                        <li><a href="#">Other</a></li>
                                    </ul>
                                </div>

                                <div class="dropdown-banner-holder">
                                    <a href="#"><img alt="" src="assets/images/banners/banner-side.png" /></a>
                                </div>
                            </div>
                            <!-- ================================== MEGAMENU VERTICAL ================================== -->                            
                        </li>
                    </ul>
                </li><!-- /.menu-item -->
                <?php endforeach; ?>
                <li><a href="#">购买主题</a></li>
            </ul><!-- /.nav -->
        </nav><!-- /.megamenu-horizontal -->
      </div>
      <!-- /.side-menu -->
      <!-- ================================== TOP NAVIGATION : END ================================== -->  
    </div>
    <!-- /.sidemenu-holder -->

    <div class="col-xs-12 col-sm-8 col-md-9 homebanner-holder">
      <!-- ========================================== SECTION – HERO ========================================= -->

      <div id="hero">
        <div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">
            <?php foreach($pic1 as $pic): ?>
            <?php  $images = $pic->pictures;?>
            <?php foreach((array)json_decode($images,true) as $k=>$picture) :?>
            <div class="item" style="background-image: url(<?php echo $picture; ?>-adpicbig);">
            <?php endforeach; ?>
            <?php endforeach; ?>
              <div class="container-fluid">
                <div class="caption vertical-center text-left">
                  <div class="big-text fadeInDown-1">
                    节省
                    <span class="big"><span class="sign">$</span>400</span>
                  </div>

                  <div class="excerpt fadeInDown-2">
                        选定的笔记本电脑<br>
                        & 台式电脑<br>
                        智能手机
                  </div>
                  <div class="small fadeInDown-2">
                    适用条件和规则
                  </div>
                  <div class="button-holder fadeInDown-3">
                    <a href="single-product.html" class="big le-button ">查看</a>
                  </div>
                </div><!-- /.caption -->
              </div><!-- /.container-fluid -->
            </div>
            <!-- /.item -->

            <?php foreach($pic2 as $pic): ?>
            <?php  $images = $pic->pictures;?>
            <?php foreach((array)json_decode($images,true) as $k=>$picture) :?>
            <div class="item" style="background-image: url(<?php echo $picture; ?>-adpicbig);">
            <?php endforeach; ?>
            <?php endforeach; ?>
              <div class="container-fluid">
                <div class="caption vertical-center text-left">
                    <div class="big-text fadeInDown-1">
                        想要<span class="big"><span class="sign">$</span>200</span>折扣?
                    </div>

                    <div class="excerpt fadeInDown-2">
                        在选定的 <br>台式电脑<br>
                    </div>
                    <div class="small fadeInDown-2">
                        适用条件和规则
                    </div>
                    <div class="button-holder fadeInDown-3">
                        <a href="single-product.html" class="big le-button ">查看</a>
                    </div>
                </div><!-- /.caption -->
              </div><!-- /.container-fluid -->
            </div><!-- /.item -->

        </div><!-- /.owl-carousel -->
      </div>

     <!-- ========================================= SECTION – HERO : END ========================================= -->     
    </div><!-- /.homebanner-holder -->

  </div><!-- /.container -->
</div><!-- /#top-banner-and-menu -->

<!-- ========================================= HOME BANNERS ========================================= -->
<section id="banner-holder" class="wow fadeInUp">
    <div class="container">
        <div class="col-xs-12 col-lg-6 no-margin banner">
            <a href="category-grid-2.html">
                <div class="banner-text theblue">
                    <h1>New Life</h1>
                    <span class="tagline">Introducing New Category</span>
                </div>
                <?php foreach($pic3 as $pic): ?>
                <?php  $images = $pic->pictures;?>
                <?php foreach((array)json_decode($images,true) as $k=>$picture) :?>
                <img class="banner-image" alt="" src="assets/images/blank.gif" data-echo="<?php echo $picture; ?>-adpicmiddle"  width="579px" height = "157px"/>
                <?php endforeach; ?>
                <?php endforeach; ?>
            </a>
        </div>
        <div class="col-xs-12 col-lg-6 no-margin text-right banner">
            <a href="category-grid-2.html">
                <div class="banner-text right">
                    <h1>Time &amp; Style</h1>
                    <span class="tagline">Checkout new arrivals</span>
                </div>
                <?php foreach($pic4 as $pic): ?>
                <?php  $images = $pic->pictures;?>
                <?php foreach((array)json_decode($images,true) as $k=>$picture) :?>
                <img class="banner-image" alt="" src="assets/images/blank.gif" data-echo="<?php echo $picture; ?>-adpicmiddle" width="579px" height = "157px"/>
                <?php endforeach; ?>
                <?php endforeach; ?>
            </a>
        </div>
    </div><!-- /.container -->
</section>
<!-- /#banner-holder -->
<!-- ========================================= HOME BANNERS : END ========================================= -->

<!-- ========================================= 推荐最新热销 ======================================-->

<div id="products-tab" class="wow fadeInUp">
    <div class="container">
        <div class="tab-holder">
            <!-- 导航标签 -->
            <ul class="nav nav-tabs" >
                <li class="active"><a href="#featured" data-toggle="tab">推荐商品</a></li>
                <li><a href="#new-arrivals" data-toggle="tab">最新上架</a></li>
                <li><a href="#top-sales" data-toggle="tab">最佳热卖</a></li>
            </ul>

            <!-- 选项面板 -->
            <div class="tab-content">
                <div class="tab-pane active" id="featured">
                    <div class="product-grid-holder">
                        <?php foreach ($data['tui'] as $pro): ?>
                        <!-- 推荐商品 -->
                        <div class="col-sm-4 col-md-3  no-margin product-item-holder hover">
                            <div class="product-item">
                                <?php if($pro->ishot): ?>
                                <div class="ribbon red">
                                    <span>hot</span>
                                </div> 
                                <?php endif; ?>
                                <?php if($pro->issale): ?>
                                <div class="ribbon green">
                                    <span>sale</span>
                                </div>
                                <?php endif; ?>
                                <div class="image">
                                    <img alt="<?php echo $pro->title; ?>" src="assets/images/blank.gif" data-echo="<?php echo $pro->cover; ?>-covermiddle" />
                                </div>
                                <div class="body">
                                    <!-- <div class="label-discount green">-50% sale</div>  -->
                                    <div class="label-discount clear"></div> 
                                    <div class="title">
                                        <a href="<?php echo yii\helpers\Url::to(['product/detail','productid'=>$pro->productid]); ?>"><?php echo $pro->title; ?></a>
                                    </div>
                                </div>
                                <div class="prices">
                                    <div class="price-prev">￥  <?php echo $pro->price;?></div>
                                    <div class="price-current pull-right">￥<?php echo $pro->saleprice; ?>  </div>
                                </div>

                                <div class="hover-area">
                                    <div class="add-cart-button">
                                        <a href="<?php echo yii\helpers\Url::to(['cart/add','productid'=>$pro->productid]); ?>" class="le-button">加入购物车</a>
                                    </div>
                                    <div class="wish-compare">
                                        <a class="btn-add-to-wishlist" href="#">加入愿望清单</a>
                                        <a class="btn-add-to-compare" href="#">比较</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        
                        <div class="loadmore-holder text-center">
                            <a class="btn-loadmore" href="#">
                                <i class="fa fa-plus"></i>
                                查看更多
                            </a>
                        </div> 

                    </div>
                </div> 

                <div class="tab-pane" id="new-arrivals">
                    <div class="product-grid-holder">
                        <?php foreach($data['new'] as $pro): ?>
                        <!-- 最新上架 -->
                        <div class="col-sm-4 col-md-3 no-margin product-item-holder hover">
                            <div class="product-item">
                                <div class="ribbon blue"><span>new!</span></div>
                                <div class="ribbon red"><span>sale</span></div> 
                                <div class="ribbon green"><span>bestseller</span></div>
                                <div class="image">
                                    <img alt="<?php echo $pro->title; ?>" src="assets/images/blank.gif" data-echo="<?php echo $pro->cover; ?>-covermiddle" />
                                </div>
                                <div class="body">
                                    <div class="label-discount clear"></div>
                                    <div class="title">
                                        <a href="<?php echo yii\helpers\Url::to(['product/detail','productid'=>$pro->productid]); ?>"><?php echo $pro->title; ?></a>
                                    </div>
                                    <div class="brand">aqie</div>
                                </div>
                                <div class="prices">
                                    <div class="price-prev">￥<?php echo $pro->price; ?></div>
                                    <div class="price-current pull-right">￥<?php echo $pro->saleprice; ?></div>
                                </div>
                                <div class="hover-area">
                                    <div class="add-cart-button">
                                        <a href="single-product.html" class="le-button">加入购物车</a>
                                    </div>
                                    <div class="wish-compare">
                                        <a class="btn-add-to-wishlist" href="#">加入愿望清单</a>
                                        <a class="btn-add-to-compare" href="#">比较</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="loadmore-holder text-center">
                        <a class="btn-loadmore" href="#">
                            <i class="fa fa-plus"></i>
                            更多商品
                        </a>
                    </div> 
                </div>

                <div class="tab-pane" id="top-sales">
                    <div class="product-grid-holder">
                        <?php foreach($data['hot'] as $pro): ?>
                        <div class="col-sm-4 col-md-3 no-margin product-item-holder hover">
                            <div class="product-item">
                                <div class="ribbon red"><span>sale</span></div> 
                                <div class="ribbon green"><span>bestseller</span></div> 
                                <div class="image">
                                    <img alt="" src="assets/images/blank.gif" data-echo="<?php echo $pro->cover; ?>-covermiddle" />
                                </div>
                                <div class="body">
                                    <div class="label-discount clear"></div>
                                    <div class="title">
                                        <a href="<?php echo yii\helpers\Url::to(['product/detail','productid'=>$pro->productid]); ?>"><?php echo $pro->title; ?>
                                        </a>
                                    </div>
                                        <div class="brand">aqie</div>
                                </div>
                                <div class="prices">
                                    <div class="price-prev">￥<?php echo $pro->price; ?></div>
                                    <div class="price-current pull-right">￥<?php echo $pro->saleprice; ?></div>
                                </div>
                                <div class="hover-area">
                                    <div class="add-cart-button">
                                        <a href="single-product.html" class="le-button">加入购物车
                                        </a>
                                    </div>
                                    <div class="wish-compare">
                                        <a class="btn-add-to-wishlist" href="#">加入愿望清单</a>
                                        <a class="btn-add-to-compare" href="#">比较</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="loadmore-holder text-center">
                        <a class="btn-loadmore" href="#">
                            <i class="fa fa-plus"></i>
                            添加更多商品
                        </a>
                    </div> 
                </div>

            </div>
        </div>
    </div>
</div>
       
<!-- ========================================= 推荐最新热销结束 =================================== -->

<!-- ========================================= BEST SELLERS ========================================= -->
<section id="bestsellers" class="color-bg wow fadeInUp">
    <div class="container">
        <h1 class="section-title">最新商品</h1>

        <div class="product-grid-holder medium">
            <div class="col-xs-12 col-md-7 no-margin">

                <div class="row no-margin">
                    <?php for ($i = 0;$i<3;$i++): ?>
                    <?php if(empty($data['all'][$i])) continue; ?>
                    <div class="col-xs-12 col-sm-4 no-margin product-item-holder size-medium hover">
                        <div class="product-item">
                            <div class="image">
                                <img alt="" src="assets/images/blank.gif" data-echo="<?php echo $data['all'][$i]->cover; ?>-covermiddle" />
                            </div>
                            <div class="body">
                                <div class="label-discount clear"></div>
                                <div class="title">
                                    <a href="<?php echo yii\helpers\Url::to(['product/detail','productid'=>$data['all'][$i]->productid]); ?>"><?php echo $data['all'][$i]->title; ?></a>
                                </div>
                                <div class="brand">aqie</div>
                            </div>
                            <div class="prices">
                                <div class="price-current text-right">￥<?php echo $data['all'][$i]->saleprice; ?></div>
                            </div>
                            <div class="hover-area">
                                <div class="add-cart-button">
                                    <a href="<?php echo yii\helpers\Url::to(['cart/add','productid'=>$data['all'][$i]->productid]); ?>" class="le-button">加入购物车</a>
                                </div>
                                <div class="wish-compare">
                                    <a class="btn-add-to-wishlist" href="#">加入愿望清单</a>
                                    <a class="btn-add-to-compare" href="#">对比</a>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.product-item-holder 中间全部商品上半部分-->
                    <?php endfor; ?>
                </div><!-- /.row -->

                <div class="row no-margin">
                    <?php for($i = 3;$i<6;$i++): ?>
                    <?php if(empty($data['all'][$i])) continue; ?>
                    <div class="col-xs-12 col-sm-4 no-margin product-item-holder size-medium hover">
                        <div class="product-item">
                            <div class="image">
                                <img alt="<?php echo $data['all'][$i]->title; ?>" src="assets/images/blank.gif" data-echo="<?php echo $data['all'][$i]->cover; ?>-covermiddle" />
                            </div>
                            <div class="body">
                                <div class="label-discount clear"></div>
                                <div class="title">
                                    <a href="<?php echo yii\helpers\Url::to(['product/detail','productid'=>$data['all'][$i]->productid]); ?>"><?php echo $data['all'][$i]->title; ?><a>
                                </div>
                                <div class="brand">aqie</div>
                            </div>
                            <div class="prices">
                                <div class="price-current text-right">￥<?php echo $data['all'][$i]->saleprice; ?></div>
                            </div>
                            <div class="hover-area">
                                <div class="add-cart-button">
                                    <a href="<?php echo yii\helpers\Url::to(['cart/add','productid'=>$data['all'][$i]->productid]); ?>" class="le-button">加入购物车</a>
                                </div>
                                <div class="wish-compare">
                                    <a class="btn-add-to-wishlist" href="#">加入愿望清单</a>
                                    <a class="btn-add-to-compare" href="#">比较</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endfor; ?>
                    <!-- /.product-item-holder 中间全部商品下半部分-->

                </div><!-- /.row -->
            </div><!-- /.col -->
            <!-- 中间部分右边轮播图 开始-->
            <div class="col-xs-12 col-md-5 no-margin">
                <div class="product-item-holder size-big single-product-gallery small-gallery">
                    <?php $last = $data['all'][count($data['all'])-1]; ?>
                    <div id="best-seller-single-product-slider" class="single-product-slider owl-carousel">
                        <div class="single-product-gallery-item" id="slide1">
                            <a data-rel="prettyphoto" href="<?php echo $last->cover; ?>">
                                <img alt="<?php echo $last->title; ?>" src="assets/images/blank.gif" data-echo="<?php echo $last->cover; ?>-coverbig" />
                            </a>
                        </div><!-- /.single-product-gallery-item -->

                        <?php foreach((array)json_decode($last->pics,true) as $key => $pic): ?> 
                        <?php $i = 2; ?>                 
                        <div class="single-product-gallery-item" id="slide<?php echo $i; ?>">
                            <a data-rel="prettyphoto" href="<?php echo $last->pics; ?>">
                                <img alt="<?php echo $last->title; ?>" src="<?php echo $pic; ?>-picsmall" data-echo="<?php echo $pic; ?>-picsmall" />
                            </a>
                        </div><!-- /.single-product-gallery-item -->
                        <?php $i++; ?>
                        <?php endforeach; ?>
                    </div><!-- /.single-product-slider -->

                    <div class="gallery-thumbs clearfix">
                        <ul>
                            <li>
                                <a class="horizontal-thumb active" data-target="#best-seller-single-product-slider" data-slide="0" href="#slide1">
                                    <img alt="<?php echo $last->title; ?>" src="assets/images/blank.gif" data-echo="<?php echo $last->cover; ?>-piclistsmall" />
                                </a>
                            </li>
                            <?php $i = 2; ?>
                            <?php foreach((array)json_decode($last->pics,true) as $key=>$pic): ?>
                            
                            <li>
                                <a class="horizontal-thumb" data-target="#best-seller-single-product-slider" data-slide="<?php echo $i-1; ?>" href="#slide2">
                                    <img alt="" src="assets/images/blank.gif" data-echo="<?php echo $pic; ?>-piclistsmall" />
                                </a>
                            </li>
                            <?php $i++; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div><!-- /.gallery-thumbs -->

                    <div class="body">
                        <div class="label-discount clear"></div>
                        <div class="title">
                            <a href="<?php echo yii\helpers\Url::to(['product/detail','productid'=>$last->productid]); ?>"><?php echo $last->title; ?></a>
                        </div>
                        <div class="brand">aqie</div>
                    </div>
                    <div class="prices text-right">
                        <div class="price-current inline">￥ <?php echo $last->saleprice; ?> </div>
                        <a href="cart.html" class="le-button big inline">加入购物车</a>
                    </div>
                </div><!-- /.product-item-holder -->
            </div><!-- /.col -->

        </div><!-- /.product-grid-holder -->
    </div><!-- /.container -->
</section>
<!-- /#bestsellers -->
<!-- ========================================= BEST SELLERS : END ========================================= -->
<!-- ========================================= RECENTLY VIEWED ========================================= -->
<section id="recently-reviewd" class="wow fadeInUp">
  <div class="container">
    <div class="carousel-holder hover">

        <div class="title-nav">
            <h2 class="h1">所有商品</h2>
        <div class="nav-holder">
          <a href="#prev" data-target="#owl-recently-viewed" class="slider-prev btn-prev fa fa-angle-left"></a>
          <a href="#next" data-target="#owl-recently-viewed" class="slider-next btn-next fa fa-angle-right"></a>
        </div>
        </div><!-- /.title-nav -->

          <div id="owl-recently-viewed" class="owl-carousel product-grid-holder">
            <?php foreach($data['all'] as $pro): ?>
            <div class="no-margin carousel-item product-item-holder size-small hover">
                <div class="product-item">
                    <div class="ribbon red"><span>sale</span></div>
                    <div class="ribbon blue"><span>new!</span></div> 
                    <div class="ribbon green"><span>bestseller</span></div>  
                    <div class="image">
                      <img alt="" src="assets/images/blank.gif" data-echo="<?php echo $pro->cover; ?>-covermiddle" />
                    </div>
                    <div class="body">
                      <div class="title">
                        <a href="<?php echo yii\helpers\Url::to(['product/detail','productid'=>$pro->productid]);  ?>"><?php echo $pro->title; ?></a>
                      </div>
                      <div class="brand">aqie</div>
                    </div>
                    <div class="prices">
                      <div class="price-current text-right">￥ <?php echo $pro->saleprice; ?></div>
                    </div>
                    <div class="hover-area">
                        <div class="add-cart-button">
                            <a href="<?php echo yii\helpers\Url::to(['cart/add','productid'=>$pro->productid]); ?>" class="le-button">加入购物车</a>
                        </div>
                        <div class="wish-compare">
                            <a class="btn-add-to-wishlist" href="#">加入愿望清单</a>
                            <a class="btn-add-to-compare" href="#">比较</a>
                        </div>
                    </div>
                </div><!-- /.product-item -->
            </div><!-- /.product-item-holder -->
            <?php endforeach; ?>
          </div><!-- /#recently-carousel -->

    </div><!-- /.carousel-holder -->
  </div><!-- /.container -->
</section><!-- /#recently-reviewd -->
<!-- ========================================= RECENTLY VIEWED : END ========================================= -->
<!-- ========================================= TOP BRANDS ========================================= -->
<section id="top-brands" class="wow fadeInUp">
    <div class="container">
        <div class="carousel-holder" >

            <div class="title-nav">
                <h1>Top Brands</h1>
                <div class="nav-holder">
                    <a href="#prev" data-target="#owl-brands" class="slider-prev btn-prev fa fa-angle-left"></a>
                    <a href="#next" data-target="#owl-brands" class="slider-next btn-next fa fa-angle-right"></a>
                </div>
            </div><!-- /.title-nav -->
            
            <div id="owl-brands" class="owl-carousel brands-carousel">

                <div class="carousel-item">
                    <a href="#">
                        <img alt="" src="assets/images/brands/brand-01.jpg" />
                    </a>
                </div><!-- /.carousel-item -->
                
                <div class="carousel-item">
                    <a href="#">
                        <img alt="" src="assets/images/brands/brand-02.jpg" />
                    </a>
                </div><!-- /.carousel-item -->
                
                <div class="carousel-item">
                    <a href="#">
                        <img alt="" src="assets/images/brands/brand-03.jpg" />
                    </a>
                </div><!-- /.carousel-item -->
                
                <div class="carousel-item">
                    <a href="#">
                        <img alt="" src="assets/images/brands/brand-04.jpg" />
                    </a>
                </div><!-- /.carousel-item -->

                <div class="carousel-item">
                    <a href="#">
                        <img alt="" src="assets/images/brands/brand-01.jpg" />
                    </a>
                </div><!-- /.carousel-item -->

                <div class="carousel-item">
                    <a href="#">
                        <img alt="" src="assets/images/brands/brand-02.jpg" />
                    </a>
                </div><!-- /.carousel-item -->

                <div class="carousel-item">
                    <a href="#">
                        <img alt="" src="assets/images/brands/brand-03.jpg" />
                    </a>
                </div><!-- /.carousel-item -->

                <div class="carousel-item">
                    <a href="#">
                        <img alt="" src="assets/images/brands/brand-04.jpg" />
                    </a>
                </div><!-- /.carousel-item -->

            </div><!-- /.brands-caresoul -->

        </div><!-- /.carousel-holder -->
    </div><!-- /.container -->
</section><!-- /#top-brands -->
<!-- ========================================= TOP BRANDS : END ========================================= -->  


