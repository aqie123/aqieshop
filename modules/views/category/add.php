<?php
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
    $this->title = '添加分类';
    $this->params['breadcrumbs'][] = ['label' => '分类管理', 'url' => ['/admin/category/list']];
    $this->params['breadcrumbs'][] = $this->title;
    $this->registerCssFile('/admin/css/compiled/new-user.css');
?>

    <!-- main container -->

        
        <div class="container-fluid">
            <div id="pad-wrapper" class="new-user">
                <div class="row-fluid header">
                    <h3>添加商品分类</h3>
                </div>

                <div class="row-fluid form-wrapper">
                    <!-- left column -->
                    <div class="span9 with-sidebar">
                        <div class="container">
                            <?php 
                                if(Yii::$app->session->getFlash('info')) {
                                    echo Yii::$app->session->getFlash('info');
                                }
                                $form = ActiveForm::begin([
                                    'fieldConfig'=>[
                                        'template'=>'<div class="span12 field-box">{label}{input}</div>{error}',                                     
                                    ],
                                    'options'=>[
                                        'class'=>'new_user_form inline-input',  // 这个是form类名
                                    ],

                                ]);
                                // $list所有分类
                                echo $form->field($model,'parentid')->dropDownList($list,['class'=>' span5']);
                                // 分类标题
                                echo $form->field($model,'title')->textInput(['class'=>'span9']);

                            ?>
                            <div class="span11 field-box actions">  
                                <?php echo Html::submitButton('添加',['class'=>'btn-glow primary']); ?>                             
                                <span>OR</span>
                                <?php echo Html::resetButton('取消',['class'=>'reset']); ?>
                            </div>                          
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>

                    <!-- side right column -->
                    <div class="span3 form-sidebar pull-right">
                        <div class="btn-group toggle-inputs hidden-tablet">
                            <button class="glow left active" data-input="inline">INLINE INPUTS</button>
                            <button class="glow right" data-input="normal">NORMAL INPUTS</button>
                        </div>
                        <div class="alert alert-info hidden-tablet">
                            <i class="icon-lightbulb pull-left"></i>
                            Click above to see difference between inline and normal inputs on a form
                        </div>                        
                        <h6>Sidebar text for instructions</h6>
                        <p>Add multiple users at once</p>
                        <p>Choose one of the following file types:</p>
                        <ul>
                            <li><a href="#">Upload a vCard file</a></li>
                            <li><a href="#">Import from a CSV file</a></li>
                            <li><a href="#">Import from an Excel file</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <!-- end main container -->

