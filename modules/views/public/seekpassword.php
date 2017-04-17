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
<html class="login-bg" lang="<?php echo Yii::$app->language; ?>">
<head>
  <title><?php echo Html::encode($this->title); ?> - 啊切商城</title>
    <?php
    $this->registerMetaTag(["name" => "viewport", "content" => "width=device-width, initial-scale=1.0"]);
    $this->registerMetaTag(["http-equiv" => "Content-type", "content" => "text/html;charset=utf-8"]);
    $this->head();
    ?>
</head>

<body>
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
                <h6>啊切商城 - 找回密码</h6>  
                <?php if(Yii::$app->session->hasFlash('info')){
                    echo Yii::$app->session->getFlash('info');
                } ?>  
                <?php  echo $form->field($model,'adminuser')->textInput(["class"=>"span12","placeholder"=>"管理员账号"]);?>
                <?php  echo $form->field($model,'adminemail')->textInput(["class"=>"span12","placeholder"=>"管理员邮箱"]);?>
                <a href="<?php echo yii\helpers\Url::to(['public/login']) ?>" class="forgot">返回登录</a>
                <?php echo Html::submitButton('找回密码', ["class"=>"btn-glow primary login"]);?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

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

                $("html").css("background-image", "url('img/bgs/" + bg + "')");
            });

        });
JS;
$this->registerJs($js);
?>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>