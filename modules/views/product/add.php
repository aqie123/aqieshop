<?php
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
?>


<!DOCTYPE html>
<html>
<head>
    <title>啊切商城 - 后台管理</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <!-- bootstrap -->
    <link href="assets/admin/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="assets/admin/css/bootstrap/bootstrap-responsive.css" rel="stylesheet" />
    <link href="assets/admin/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- libraries -->
    <link href="assets/admin/css/lib/bootstrap-wysihtml5.css" type="text/css" rel="stylesheet" />
    <link href="assets/admin/css/lib/uniform.default.css" type="text/css" rel="stylesheet" />
    <link href="assets/admin/css/lib/select2.css" type="text/css" rel="stylesheet" />
    <link href="assets/admin/css/lib/bootstrap.datepicker.css" type="text/css" rel="stylesheet" />
    <link href="assets/admin/css/lib/font-awesome.css" type="text/css" rel="stylesheet" />

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="assets/admin/css/layout.css" />
    <link rel="stylesheet" type="text/css" href="assets/admin/css/elements.css" />
    <link rel="stylesheet" type="text/css" href="assets/admin/css/icons.css" />
    
    <!-- this page specific styles -->
    <link rel="stylesheet" href="assets/admin/css/compiled/form-showcase.css" type="text/css" media="screen" />

    <!-- open sans font -->
    

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>

    <!-- navbar -->
    <div class="navbar navbar-inverse">
        <div class="navbar-inner">
            <button type="button" class="btn btn-navbar visible-phone" id="menu-toggler">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            
            <a class="brand" href="index.html" style="font-weight:700;font-family:Microsoft Yahei">啊切商城 - 后台管理</a>

            <ul class="nav pull-right">                
                <li class="hidden-phone">
                    <input class="search" type="text" />
                </li>
                <li class="notification-dropdown hidden-phone">
                    <a href="#" class="trigger">
                        <i class="icon-warning-sign"></i>
                        <span class="count">6</span>
                    </a>
                    <div class="pop-dialog">
                        <div class="pointer right">
                            <div class="arrow"></div>
                            <div class="arrow_border"></div>
                        </div>
                        <div class="body">
                            <a href="#" class="close-icon"><i class="icon-remove-sign"></i></a>
                            <div class="notifications">
                                <h3>你有 6 个新通知</h3>
                                <a href="#" class="item">
                                    <i class="icon-signin"></i> 新用户注册
                                    <span class="time"><i class="icon-time"></i> 13 分钟前.</span>
                                </a>
                                <a href="#" class="item">
                                    <i class="icon-signin"></i> 新用户注册
                                    <span class="time"><i class="icon-time"></i> 18 分钟前.</span>
                                </a>
                                <a href="#" class="item">
                                    <i class="icon-signin"></i> 新用户注册
                                    <span class="time"><i class="icon-time"></i> 49 分钟前.</span>
                                </a>
                                <a href="#" class="item">
                                    <i class="icon-download-alt"></i> 新订单
                                    <span class="time"><i class="icon-time"></i> 1 天前.</span>
                                </a>
                                <div class="footer">
                                    <a href="#" class="logout">查看所有通知</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                
                <li class="notification-dropdown hidden-phone">
                    <a href="#" class="trigger">
                        <i class="icon-envelope-alt"></i>
                    </a>
                    <div class="pop-dialog">
                        <div class="pointer right">
                            <div class="arrow"></div>
                            <div class="arrow_border"></div>
                        </div>
                        <div class="body">
                            <a href="#" class="close-icon"><i class="icon-remove-sign"></i></a>
                            <div class="messages">
                                <a href="#" class="item">
                                    <img src="assets/admin/img/contact-img.png" class="display" />
                                    <div class="name">Alejandra Galván</div>
                                    <div class="msg">
                                        There are many variations of available, but the majority have suffered alterations.
                                    </div>
                                    <span class="time"><i class="icon-time"></i> 13 min.</span>
                                </a>
                                <a href="#" class="item">
                                    <img src="assets/admin/img/contact-img2.png" class="display" />
                                    <div class="name">Alejandra Galván</div>
                                    <div class="msg">
                                        There are many variations of available, have suffered alterations.
                                    </div>
                                    <span class="time"><i class="icon-time"></i> 26 min.</span>
                                </a>
                                <a href="#" class="item last">
                                    <img src="assets/admin/img/contact-img.png" class="display" />
                                    <div class="name">Alejandra Galván</div>
                                    <div class="msg">
                                        There are many variations of available, but the majority have suffered alterations.
                                    </div>
                                    <span class="time"><i class="icon-time"></i> 48 min.</span>
                                </a>
                                <div class="footer">
                                    <a href="#" class="logout">View all messages</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle hidden-phone" data-toggle="dropdown">
                        账户管理
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo yii\helpers\Url::to(['manage/changeemail']); ?>">修改邮箱</a></li>
                        <li><a href="<?php echo yii\helpers\Url::to(['manage/changepass']); ?>">修改密码</a></li>
                        <li><a href="#">订单管理</a></li>
                    </ul>
                </li>
                <li class="settings hidden-phone">
                    <a href="personal-info.html" role="button">
                        <i class="icon-cog"></i>
                    </a>
                </li>
                <li class="settings hidden-phone">
                    <a href="<?php echo yii\helpers\Url::to(['public/logout']) ?>" role="button">
                        <i class="icon-share-alt"></i>
                    </a>
                </li>
            </ul>            
        </div>
    </div>
    <!-- end navbar -->

    <!-- sidebar -->
    <div id="sidebar-nav">
        <ul id="dashboard-menu">
            <li class="active">
                <div class="pointer">
                    <div class="arrow"></div>
                    <div class="arrow_border"></div>
                </div>
                <a href="<?php echo yii\helpers\Url::to(['default/index']) ?>">">
                    <i class="icon-home"></i>
                    <span>后台首页</span>
                </a>
            </li>            
            <li>
                <a href="chart-showcase.html">
                    <i class="icon-signal"></i>
                    <span>统计</span>
                </a>
            </li>
            <li>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-user"></i>
                    <span>管理员管理</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                    <li><a href="<?php echo yii\helpers\Url::to(['manage/managers']) ?>">管理员列表</a></li>
                    <li><a href="<?php echo yii\helpers\Url::to(['manage/reg']) ?>">添加新管理员</a></li>
                </ul>
            </li>
            <li>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-group"></i>
                    <span>用户管理</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                    <li><a href="<?php echo yii\helpers\Url::to(['user/users']) ?>">用户列表</a></li>
                    <li><a href="<?php echo yii\helpers\Url::to(['user/reg']) ?>">添加用户</a></li>
                </ul>
            </li>
            <li>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-list"></i>
                    <span>分类管理</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                    <li><a href="<?php echo yii\helpers\Url::to(['category/list']); ?>">分类列表</a></li>
                    <li><a href="<?php echo yii\helpers\Url::to(['category/add']) ?>">添加分类</a></li>
                </ul>
            </li>
            <li>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-glass"></i>
                    <span>商品管理</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                    <li><a href="<?php echo yii\helpers\Url::to(['product/list']); ?>">商品列表</a></li>
                    <li><a href="<?php echo yii\helpers\Url::to(['product/add']); ?>">添加商品</a></li>
                </ul>
            </li>
            <li>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-edit"></i>
                    <span>订单管理</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                    <li><a href="<?php echo yii\helpers\Url::to(['order/list']); ?>">订单列表</a></li>
                </ul>
            </li>
            <li>
                <a class="dropdown-toggle" href="#">
                    <i class="icon-picture"></i>
                    <span>相册管理</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="<?php echo yii\helpers\Url::to(['pictures/add']); ?>">添加图片</a>
                        <a href="<?php echo yii\helpers\Url::to(['pictures/list']); ?>">图片列表</a>
                    </li>
                </ul>           
            </li>
            <li>
                <a href="calendar.html">
                    <i class="icon-calendar-empty"></i>
                    <span>日历事件管理</span>
                </a>
            </li>
            <li>
                <a href="tables.html">
                    <i class="icon-th-large"></i>
                    <span>表格</span>
                </a>
            </li>
            
            <li>
                <a href="personal-info.html">
                    <i class="icon-cog"></i>
                    <span>我的信息</span>
                </a>
            </li>
            
        </ul>
    </div>
    <!-- end sidebar -->


    <!-- main container -->
    <div class="content">
        
        <div class="container-fluid">
            <div id="pad-wrapper" class="form-page">
                <!-- <div class="row-fluid header">
                    <h3>添加商品</h3>
                </div> -->
                <div class="row-fluid form-wrapper addfood">
                    <style type="text/css">
                        div.radio{
                            /*display: block; 特喵的好烦*/
                            width:auto;
                        }
                    </style>
                    
                    <!-- left column -->
                    <div class="span8 column">
                        <?php 
                            if(Yii::$app->session->hasFlash('info')) {
                                echo Yii::$app->session->getFlash('info');
                            }
                            $form = ActiveForm::begin([
                                'fieldConfig' =>[
                                    'template'=>'{error}<div class="field-box ">{label}{input}</div>',
                                ],
                                

                            ]);
                            // $model 后面对应数据库字段
                            echo $form->field($model,'cateid')->dropDownList($opts,['id'=>'cates','class'=>'span5']);
                            echo $form->field($model,'title')->textInput(['class'=>'span8 inline-input','data-toggle'=>'tooltip','data-trigger' =>'focus','title'=>'lalala','data-placement'=>'right','type'=>'text']);
 
                            echo $form->field($model,'description',[
                                'template'=>'<div class="field-box">{label}<div class="wysi-column">{input}</div></div>{error}',

                                ])->textarea(['id'=>'wysi','class'=>'span10 wysihtml5 wysi-column','rows'=>'5']);
                            echo $form->field($model,'price')->textInput(['class'=>'span8 inline-input']);
                            echo $form->field($model,'ishot')->radioList([0=>'不热卖',1=>'热卖'],['class'=>'span8']);
                            echo $form->field($model, 'issale')->radioList(['不促销', '促销'], ['class' => 'span8']);
                            echo $form->field($model, 'saleprice')->textInput(['class' => 'span9']);
                            echo $form->field($model, 'num')->textInput(['class' => 'span9']);
                            echo $form->field($model, 'ison')->radioList(['下架', '上架'], ['class' => 'span8']);
                            echo $form->field($model, 'istui')->radioList(['不推荐', '推荐'], ['class' => 'span8']);
                            echo $form->field($model, 'cover')->fileInput(['class' => 'span9']);
                            if(!empty($model->cover)) :
                              ?> 
                             <img src="<?php echo $model->cover;?>-covermiddle">
                             <hr> 
                            <?php
                                endif;
                                echo $form->field($model, 'pics[]')->fileInput(['class' => 'span9', 'multiple' => true,]);
                            ?> 
                            <?php foreach((array)json_decode($model->pics,true) as $k=>$pic) { ?>
                            <img src="<?php echo $pic ?>-coversmall" alt="">
                            <a href="<?php echo yii\helpers\Url::to(['product/removepic','key'=>$k,'productid'=>$model->productid]); ?>">删除</a>
                            <?php } ?>
                            <hr>
                            <input type="button" name="" id="addpic" value="增加一个">
                            <div class="span11 field-box actions text-right">
                                <?php echo Html::submitButton('提交',['class'=>'btn-glow primary']); ?>
                                <span>或者</span>
                                <?php echo Html::resetButton('取消',['class'=>'reset']); ?>
                            </div>
                                                
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end main container -->

    <!-- scripts for this page -->
    <script src="assets/admin/js/wysihtml5-0.3.0.js"></script>
    <script src="assets/admin/js/jquery-latest.js"></script>
    <script src="assets/admin/js/bootstrap.min.js"></script>
    <script src="assets/admin/js/bootstrap-wysihtml5-0.0.2.js"></script>
    <script src="assets/admin/js/bootstrap.datepicker.js"></script>
    <script src="assets/admin/js/jquery.uniform.min.js"></script>
    <script src="assets/admin/js/select2.min.js"></script>
    <script src="assets/admin/js/theme.js"></script>

    <!-- call this page plugins -->
    <script type="text/javascript">
        $(function () {

            // add uniform plugin styles to html elements
            $("input:checkbox, input:radio").uniform();

            // select2 plugin for select elements
            $(".select2").select2({
                placeholder: "Select a State"
            });

            // datepicker plugin
            $('.datepicker').datepicker().on('changeDate', function (ev) {
                $(this).datepicker('hide');
            });

            // wysihtml5 plugin on textarea
            $(".wysihtml5").wysihtml5({
                "font-styles": false
            });

            // 添加图片
            $("#addpic").click(function(){
                var pic = $("#product-pics").clone();
                pic.attr("style", "margin-left:140px");
                $("#product-pics").parent().append(pic);
            });
        });
    </script>

</body>
</html>