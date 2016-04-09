<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'adminlte/css/font-awesome.min.css',
        'adminlte/css/ionicons.min.css',
        'adminlte/css/AdminLTE.css',
		'adminlte/css/content.css',
    ];
    public $js = [
        'adminlte/js/AdminLTE/app.js',
        'adminlte/js/echarts.common.min.js',
        'adminlte/js/bootbox.js',
        'adminlte/js/bootstrap.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
