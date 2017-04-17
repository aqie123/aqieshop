<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * 后台资源
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminAsset extends AssetBundle
{
    // 资源文件，并可web访问目录
    public $basePath = '@webroot';
    // 访问资源文件的URL
    public $baseUrl = '@web';

    public $css = [
        // bootstrap  使用后台不依赖框架的bootstrap
      "admin/css/bootstrap/bootstrap.css",
      "admin/css/bootstrap/bootstrap-responsive.css",
      "admin/css/bootstrap/bootstrap-overrides.css",
      // libraries
      //"admin/css/lib/jquery-ui-1.10.2.custom.css",
      "admin/css/lib/font-awesome.css",
      //global styles
      "admin/css/layout.css",
      "admin/css/elements.css",
      "admin/css/icons.css",
      //"admin/css/compiled/index.css",
      //"admin/css/compiled/user-list.css",
      //"admin/css/compiled/new-user.css",
      // 商品添加

      //"admin/css/lib/bootstrap-wysihtml5.css",
      //"admin/css/lib/uniform.default.css",
      //"admin/css/lib/select2.css",
      //"admin/css/lib/bootstrap.datepicker.css",
      //"admin/css/compiled/form-showcase.css",
      // 添加图片
      //"admin/css/compiled/gallery.css",

    ];
    public $js = [
        // 通用scripts
        "admin/js/bootstrap.min.js",
        "admin/js/theme.js",
        //"admin/js/jquery-ui-1.10.2.custom.min.js",
       // "admin/js/jquery.knob.js",
        // flot charts
        //"admin/js/jquery.flot.js",
       // "admin/js/jquery.flot.stack.js",
        //"admin/js/jquery.flot.resize.js",


        //'admin/js/wysihtml5-0.3.0.js',
        //'admin/js/bootstrap-wysihtml5-0.0.2.js',
        //'admin/js/uploadpic.js',

        // add goods
        //'admin/js/bootstrap.datepicker.js',
        //'admin/js/jquery.uniform.min.js',
        //'admin/js/select2.min.js',
        ['http://html5shim.googlecode.com/svn/trunk/html5.js', 'condition' => 'lte IE9', 'position' => \yii\web\View::POS_HEAD],
    ];
    // 资源包依赖其他资源包 (加载资源文件先依赖这两个包)
    public $depends = [
        'yii\web\YiiAsset',
    ];


}
