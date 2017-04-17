<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = '添加图片';
$this->params['breadcrumbs'][] = ['label' => '相册管理', 'url' => ['/admin/pictures/list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- main container -->

<div class="container-fluid">
    <div id="pad-wrapper" class="gallery">
        <div class="row-fluid header">
            <h3>相册</h3>
        </div>
        <div class="row-fluid form-wrapper">
            <?php
            if (Yii::$app->session->hasFlash('info')) {
                echo Yii::$app->session->getFlash('info');
            }
            $form = ActiveForm::begin([
                'fieldConfig' => [
                    'template' => '{error}<div class="field-box ">{label}{input}</div>',
                ],


            ]);
            ?>
            <?php
            echo $form->field($model, 'pictures[]')->fileInput(['class' => 'span9', 'multiple' => true,]);
            ?>
            <?php foreach ((array)json_decode($model->pictures, true) as $k => $picture) { ?>
                <img src="<?php echo $picture ?>-coversmall" alt="">
                <a href="<?php echo yii\helpers\Url::to(['pictures/removepic', 'key' => $k, 'pictureid' => $model->pictureid]); ?>">删除</a>
            <?php } ?>
            <hr>
            <input type="button" name="" id="addpic" value="增加一个">
            <br>
            <?php echo Html::submitButton('提交', ['class' => 'btn-glow primary']); ?>
            <span>或者</span>
            <?php echo Html::resetButton('取消', ['class' => 'reset']); ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>


<?php
$js = <<<JS
        // 添加图片
        $("#addpic").click(function(){
            var pic = $("#picture-pictures").clone();
            // pic.attr("style", "margin-left:140px");
            $("#picture-pictures").parent().append(pic);
        }); 
JS;
$this->registerJs($js);
?>

    
    