<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$this->title = '商品添加';
$this->params['breadcrumbs'][] = ['label' => '商品管理', 'url' => ['/admin/product/list']];
$this->params['breadcrumbs'][] = $this->title;
// libraries
    $this->registerCssFile('/admin/css/lib/bootstrap-wysihtml5.css');
    $this->registerCssFile('/admin/css/lib/uniform.default.css');
    $this->registerCssFile('/admin/css/lib/select2.css');
    $this->registerCssFile('/admin/css/lib/bootstrap.datepicker.css');
    $this->registerCssFile('/admin/css/compiled/form-showcase.css');
    $this->registerCssFile('/admin/css/compiled/new-user.css');

$css = <<<CSS
    .addfood .radio{
        /*display: block; 特喵的好烦*/
        width:auto;
    }
    div.radio input{
        opacity: 1; 
    }
CSS;
$this->registerCss($css);

?>
    <!-- main container -->
        
        <div class="container-fluid">
            <div id="pad-wrapper" class="form-page">

                <div class="row-fluid form-wrapper addfood">

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
                                'template'=>'{error}<div class="field-box">{label}<div class="wysi-column">{input}</div></div>',

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
    <!-- end main container -->




<?php


$js = <<<JS
    $(function () {
        // add uniform plugin styles to html elements
            //$("input:checkbox, input:radio").uniform();
            

            // 添加图片
            $("#addpic").click(function(){
                var pic = $("#product-pics").clone();
                pic.attr("style", "margin-left:140px");
                $("#product-pics").parent().append(pic);
            });
             /*
            $(".wysihtml5").wysihtml5({
                "font-styles": false
            });
           
             select2 plugin for select elements
            $(".select2").select2({
                //placeholder: "Select a State"
            });
             datepicker plugin
            $('.datepicker').datepicker().on('changeDate', function (ev) {
                 $(this).datepicker('hide');
            });
           */
        });
JS;
$this->registerJs($js);
// ['depends' => \app\assets\AppAsset::className()]
//$this->registerJsFile('/admin/js/wysihtml5-0.3.0.js',['depends' => \yii\web\JqueryAsset::className()]);
//$this->registerJsFile('/admin/js/bootstrap-wysihtml5-0.0.2.js',['depends' => \yii\web\JqueryAsset::className()]);
//$this->registerJsFile('/admin/js/bootstrap.datepicker.js',['depends' => \yii\web\JqueryAsset::className()]);
//$this->registerJsFile('/admin/js/jquery.uniform.min.js',['depends' => \yii\web\JqueryAsset::className()]);
//$this->registerJsFile('/admin/js/select2.min.js',['depends' => \yii\web\JqueryAsset::className()]);
?>


