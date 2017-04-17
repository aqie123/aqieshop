<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = '授权';
$this->params['breadcrumbs'][] = ['label' => '管理员管理', 'url' => ['/admin/manage/managers']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('/admin/css/compiled/new-user.css');
$css = <<<CSS
        .new-user .form-wrapper .child-node label {
            width: 200px;
        }
        .new-user .form-wrapper .child-node>label:nth-child(1){
            /*background: red;*/
            width:100%;
            display: block;
        }
        
        .child-node label{
            /*margin-right: 100px;*/
            /*width: 130px;*/
            /*box-sizing: border-box;*/
            /*padding: 0 0px;*/
        }
        .child-node label:nth-child(3n){
             /*margin-right: 0;*/
        }
        
CSS;
$this->registerCss($css);
?>
<!-- main container -->

<div class="container-fluid">
    <div id="pad-wrapper" class="new-user">
        <div class="row-fluid header">
            <h3>授权</h3>
        </div>

        <div class="row-fluid form-wrapper">
            <!-- left column -->
            <div class="span9 with-sidebar">
                <div class="container">
                    <?php
                    if (Yii::$app->session->hasFlash('info')) {
                        echo Yii::$app->session->getFlash('info');
                    }
                    $form = ActiveForm::begin([
                        'options' => ['class' => 'new_user_form inline-input'],
                        'fieldConfig' => [
                            'template' => '<div class="span12 field-box">{label}{input}</div>{error}'
                        ],
                    ]);
                    /*
                        echo $form->field($model, 'username')->textInput(['class' => 'span9']);
                        echo $form->field($model, 'useremail')->textInput(['class' => 'span9']);
                        echo $form->field($model, 'userpass')->passwordInput(['class' => 'span9']);
                        echo $form->field($model, 'repass')->passwordInput(['class' => 'span9']);
                    */
                    ?>
                    <div class="span12 field-box">
                        <?php echo Html::label('管理员',null).Html::encode($admin); ?>
                    </div>
                    <div class="span12 field-box">
                        <?php echo Html::label('角色',null).Html::checkboxList('children', $children['roles'], $roles); ?>
                    </div>
                    <div class="span12 field-box child-node">
<!--                        permission-->
                        <?php echo Html::label('权限',null).Html::checkboxList('children', $children['permissions'], $permissions); ?>
                    </div>
                    <div class="span11 field-box actions">
                        <?php echo Html::submitButton('授权', ['class' => 'btn-glow primary']); ?>
                        <span>或者</span>
                        <?php echo Html::resetButton('取消', ['class' => 'reset']); ?>

                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

            <!-- side right column -->
            <div class="span3 form-sidebar pull-right">

                <div class="alert alert-info hidden-tablet">
                    <i class="icon-lightbulb pull-left"></i>
                    请在左侧填写管理员相关信息，包括管理员账号，电子邮箱，以及密码
                </div>
                <h6>重要提示：</h6>
                <p>管理员可以管理后台功能模块</p>
                <p>请谨慎添加</p>
            </div>
        </div>
    </div>
</div>
<!-- end main container -->


