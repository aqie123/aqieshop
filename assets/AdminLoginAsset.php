<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminLoginAsset extends AssetBundle
{
    // 资源文件，并可web访问目录
    public $basePath = '@webroot';
    // 访问资源文件的URL
    public $baseUrl = '@web';

    public $css = [
        'admin/css/bootstrap/bootstrap.css',
        'admin/css/bootstrap/bootstrap-responsive.css',
        'admin/css/bootstrap/bootstrap-overrides.css',
        'admin/css/lib/jquery-ui-1.10.2.custom.css',
        'admin/css/lib/font-awesome.css',
        'admin/css/layout.css',
        'admin/css/elements.css',
        'admin/css/icons.css',
        'admin/css/compiled/signin.css',
        'admin/css/lib/bootstrap-wysihtml5.css',
        'admin/css/compiled/form-showcase.css',

    ];
    public $js = [
        'admin/js/bootstrap.min.js',
        'admin/js/theme.js',
        ['http://html5shim.googlecode.com/svn/trunk/html5.js', 'condition' => 'lte IE9', 'position' => \yii\web\View::POS_HEAD],
    ];
    // 资源包依赖其他资源包 (加载资源文件先依赖这两个包)
    public $depends = [
        'yii\web\YiiAsset',

    ];

}
