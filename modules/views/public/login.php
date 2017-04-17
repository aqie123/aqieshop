<?php
    //帮助创建表单
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
    use app\assets\AdminLoginAsset;
    AdminLoginAsset::register($this);
?>

<?php
$this->beginPage();
?>
<!DOCTYPE html>
<html  lang="<?php echo Yii::$app->language; ?>">
<head>
  <title><?php echo Html::encode($this->title); ?> - 后台管理</title>
    <?php
    $this->registerMetaTag(["name" => "viewport", "content" => "width=device-width, initial-scale=1.0"]);
    $this->registerMetaTag(["http-equiv" => "Content-type", "content" => "text/html;charset=utf-8"]);
    $this->head();
    ?>
    
</head>
<body class="login-bg">
<?php $this->beginBody(); ?>


    <div class="row-fluid login-wrapper">
        <a class="brand" href="index.html"></a>
        <?php $form =  ActiveForm::begin([
            'fieldConfig' =>[                       //针对每个字段template属性
                'template' => '{error}{input}',
            ]

        ]); ?> 
        <div class="span4 box">
            <div class="content-wrap">
                <h6>啊切商城 - 后台管理</h6>    
                <?php  echo $form->field($model,'adminuser')->textInput(["class"=>"span12","placeholder"=>"管理员账号 test"]);?>
                <?php  echo $form->field($model,'adminpass')->passwordInput(["class"=>"span12","placeholder"=>"管理员密码 123"]);?>
                <a href="<?php echo yii\helpers\Url::to(['public/seekpassword']) ?>" class="forgot">忘记密码?</a>
                <?php echo $form->field($model,'rememberMe')->checkbox([
                    'id'=>'remember-me',
                    'template'=>'<div class="remember">{input}<label for="remember-me">记住我</label></div>',

                ]);?>
                <?php echo Html::submitButton('登录', ["class"=>"btn-glow primary login"]);?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>



    <!-- pre load bg imgs -->
<?php
$js = <<<JS

        $(function () {
            // bg switcher
            var \$btns = $(".bg-switch .bg");
            \$btns.click(function (e) {
                e.preventDefault();
                \$btns.removeClass("active");
                $(this).addClass("active");
                var bg = $(this).data("img");

                $("html").css("background-image", "url('assets/admin/js/bgs/" + bg + "')");
            });

        });
JS;
$this->registerJs($js);
?>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>