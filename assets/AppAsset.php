<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * 前台资源
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    // 资源文件，并可web访问目录 web路径
    public $basePath = '@webroot';      //basic/web
    // 访问资源文件的URL
    public $baseUrl = '@web';

    // public $sourcePath = '/tmp/src'     // 这个会将该目录下资源复制到assets目录下
    //资源包文件数组
    public $css = [
        'css/main.css',
        'css/green.css',
        'css/owl.carousel.css',
        'css/owl.transitions.css',
        'css/animate.min.css',
        'css/font-awesome.min.css',

    ];
    public $js = [
        'js/jquery-migrate-1.2.1.js',
        'js/gmap3.min.js',
        'js/bootstrap-hover-dropdown.min.js',
        'js/owl.carousel.min.js',
        'js/css_browser_selector.min.js',
        'js/echo.min.js',
        'js/jquery.easing-1.3.min.js',
        'js/bootstrap-slider.min.js',
        'js/jquery.raty.min.js',
        'js/jquery.prettyPhoto.min.js',
        'js/jquery.customSelect.min.js',
        'js/wow.min.js',
        'js/scripts.js',
        // HTML5 elements and media queries Support for IE8 : HTML5 shim and Respond.js
        ['js/html5shiv.js','condition'=>'lte IE9','position'=>\yii\web\View::POS_HEAD],
        ['js/respond.min.js','condition'=>'lte IE9','position'=>\yii\web\View::POS_HEAD],
    ];
    // 资源包依赖其他资源包 (加载资源文件先依赖这两个包)
    public $depends = [
        'yii\web\YiiAsset',
        // 加载bootstrap.css
        'yii\bootstrap\BootstrapAsset',
        // 默认没有加载bootstrap.js
        'yii\bootstrap\BootstrapPluginAsset',

    ];

    // (css配置项)
    public $cssOptions = [
        // 'noscript' => true,      // 不加载css
    ];


    public $jsOptions = [
        // 'condition' => 'lte IE9',        // 仅在ie9以下显示
        // 都处在头部
        // 'position' => \yii\web\View::POS_HEAD
    ];

    //后续资源放在web目录下
    // 23行 public配置项
    public $publishOptions = [
       /* 'only' =>[
            'css',
            'fonts',
        ],
       */
    ];
}
