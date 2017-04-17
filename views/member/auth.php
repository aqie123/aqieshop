<?php
    //帮助创建表单
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
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
          <h2 class="bordered">用户登录</h2>
          <p>Hello, Welcome to your account</p>

          <div class="social-auth-buttons">
            <div class="row">
              <div class="col-md-6">
                <button class="btn-block btn-lg btn btn-facebook"><i class="fa fa-qq"></i> Sign In with QQ</button>
              </div>
              <div class="col-md-6">
                <button class="btn-block btn-lg btn btn-twitter"><i class="fa fa-weibo"></i> Sign In with Weibo</button>
              </div>
            </div>
          </div>
          <?php $form = ActiveForm::begin([
                  'fieldConfig' =>[
                    'template' => '<div class="field-row">{label}{input}</div>{error}'
                  ],
                  'options' =>[
                    'class' =>'login-form cf-style-1',
                    'role'=>'form',
                  ],
                  'action' =>['member/auth'],
                ]);
          ?>
            <?php echo $form->field($model,'loginname')->textInput(['class'=>'le-input']); ?>
            <?php echo $form->field($model,'userpass')->textInput(['class'=>'le-input']); ?>
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
                <?php echo Html::submitButton('安全登录',['class' =>'le-button huge']); ?>
            </div><!-- /.buttons-holder -->
          <?php ActiveForm::end(); ?>
        </section><!-- /.sign-in -->
      </div><!-- /.col -->

      <div class="col-md-6">
        <section class="section register inner-left-xs">
          <h2 class="bordered">新用户注册</h2>
          <p>若由于网络因素失败，请回到页面重试</p>
          <?php 
            if(Yii::$app->session->hasFlash('info')){
              echo Yii::$app->session->getFlash('info');
            }

             $form = ActiveForm::begin([
              'fieldConfig'=>[
                'template' => '<div class="field-row">{label}{input}</div>{error}'
              ],
              'options'=>[
                'class'=>'register-form cf-style-1',
                'role' =>'form',
              ],
              'action' =>['member/reg'],
             ]);
          ?>
          <?php echo $form->field($model, 'useremail')->textInput(['class' => 'le-input']); ?>

          <div class="buttons-holder">
              <?php echo Html::submitButton('注册',['class'=>'le-button huge']); ?>
          </div><!-- /.buttons-holder -->
          <?php ActiveForm::end(); ?>

          <h2 class="semi-bold">Sign up today and you'll be able to :</h2>

          <ul class="list-unstyled list-benefits">
            <li><i class="fa fa-check primary-color"></i> Speed your way through the checkout</li>
            <li><i class="fa fa-check primary-color"></i> Track your orders easily</li>
            <li><i class="fa fa-check primary-color"></i> Keep a record of all your purchases</li>
          </ul>

        </section><!-- /.register -->

      </div><!-- /.col -->

    </div><!-- /.row -->
  </div><!-- /.container -->
</main><!-- /.authentication -->
<!-- ========================================= MAIN : END ========================================= -->   <!-- ============================================================= FOOTER ============================================================= -->
