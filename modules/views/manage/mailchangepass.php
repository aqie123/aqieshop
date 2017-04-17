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
        <a class="brand" href="<?php echo yii\helpers\Url::to(['/index/index']) ?>"></a>
        <?php $form =  ActiveForm::begin([
            'fieldConfig' =>[                       //针对每个字段template属性
                'template' => '{error}{input}',
            ]

        ]); ?> 
        <div class="span4 box">
            <div class="content-wrap">
                <h6>啊切商城 - 邮箱修改密码</h6>
                <?php 
                    if(Yii::$app->session->hasFlash('info')){
                        echo Yii::$app->session->getFlash('info');
                    }

                 ?>

                <?php  echo $form->field($model,'adminuser')->hiddenInput();?>
                <?php  echo $form->field($model,'adminpass')->passwordInput(["class"=>"span12","placeholder"=>"新密码"]);?>
                <?php  echo $form->field($model,'repass')->passwordInput(["class"=>"span12","placeholder"=>"确认密码"]);?>
                <a href="<?php echo yii\helpers\Url::to(['public/login']) ?>" class="forgot">返回登录</a>
                
                <?php echo Html::submitButton('修改', ["class"=>"btn-glow primary login"]);?>
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