<?php
    //帮助创建表单
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
    $this->title = "前台登录";
?>  

<!-- ========================================= NAVIGATION : END ========================================= -->
  <div class="animate-dropdown"><!-- ========================================= BREADCRUMB ========================================= -->
<div id="breadcrumb-alt">
    <div class="container">
        <div class="breadcrumb-nav-holder minimal">
            <ul>
                <li class="dropdown breadcrumb-item">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Media Center
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Computer Cases &amp; Accessories</a></li>
                        <li><a href="#">CPUs, Processors</a></li>
                        <li><a href="#">Fans, Heatsinks &amp; Cooling</a></li>
                        <li><a href="#">Graphics, Video Cards</a></li>
                        <li><a href="#">Interface, Add-On Cards</a></li>
                        <li><a href="#">Laptop Replacement Parts</a></li>
                        <li><a href="#">Memory (RAM)</a></li>
                        <li><a href="#">Motherboards</a></li>
                        <li><a href="#">Motherboard &amp; CPU Combos</a></li>
                        <li><a href="#">Motherboard Components</a></li>
                    </ul>
                </li>
                <li class="breadcrumb-item">
                    <a href="#">Home</a>
                </li>
                <li class="breadcrumb-item current">
                    <a href="#">Authentication</a>
                </li>
            </ul>
        </div><!-- /.breadcrumb-nav-holder -->
    </div><!-- /.container -->
</div><!-- /#breadcrumb-alt -->
<!-- ========================================= BREADCRUMB : END ========================================= --></div>
</header>
<!-- ============================================================= HEADER : END ============================================================= -->   <!-- ========================================= MAIN ========================================= -->
<main id="authentication" class="inner-bottom-md">
  <div class="container">
    <div class="row">
      
      <div class="col-md-6">
        <section class="section sign-in inner-right-xs">
          <h2 class="bordered">
              <img src="<?php echo Yii::$app->session['userinfo']['figureurl_1']; ?>" style="border-radius: 50px">
              完善信息
          </h2>
          <p>请填写用户名和密码绑定该qq</p>


          <?php $form = ActiveForm::begin([
                  'fieldConfig' =>[
                    'template' => '<div class="field-row">{label}{input}</div>{error}'
                  ],
                  'options' =>[
                    'class' =>'login-form cf-style-1',
                    'role'=>'form',
                  ],
                  // 'action' =>['member/auth'],
                ]);
          ?>
            <input type="text" value="<?php echo Yii::$app->session['userinfo']['nickname'] ?>" class="le-input" readonly="readonly"><br>
            <?php echo $form->field($model,'username')->textInput(['class'=>'le-input']); ?>
            <?php echo $form->field($model,'userpass')->textInput(['class'=>'le-input']); ?>
            <?php echo $form->field($model,'repass')->textInput(['class'=>'le-input']); ?>
            <div class="field-row clearfix">
              <span class="pull-left">
                <?php echo $form->field($model,'rememberMe')->checkbox([
                  'template' =>'<span class="pull-left"><label for="" class="content-color">{input}<span class="bold">记住我</span></label></span>',
                  'class' =>'le-checkbox auto-width inline',

                ]) ?>
              </span>
              <span class="pull-right">
                <a href="#" class="content-color bold">Forgotten Password ?</a>
              </span>
            </div>

            <div class="buttons-holder">
                <?php echo Html::submitButton('完善信息',['class' =>'le-button huge']); ?>
            </div><!-- /.buttons-holder -->
          <?php ActiveForm::end(); ?>
        </section><!-- /.sign-in -->
      </div><!-- /.col -->



    </div><!-- /.row -->
  </div><!-- /.container -->
</main><!-- /.authentication -->
<!-- ========================================= MAIN : END ========================================= -->   <!-- ============================================================= FOOTER ============================================================= -->


