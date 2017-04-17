<?php

namespace app\modules\controllers;

use yii\web\Controller;
use app\modules\controllers\CommonController;
use Yii;


/**
 * Default controller for the `admin` module
 */
class DefaultController extends CommonController
{
    /**
     * 加载后台首页
     * Renders the index view for the module
     * @return string
     */
    protected $mustlogin = ['index'];
    public function actionIndex()
    {
        $this->layout = "layout1";
        return $this->render('index');
    }
}
