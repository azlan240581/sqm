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
class AppAsset extends AssetBundle
{
	public $basePath = '@webroot';
    public $baseUrl = '/cmp/contents';

    public $css = [
        //'css/bootstrap/bootstrap.min.css',
        '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
        '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
		'//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css',
		'//cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css',
        'css/dist/AdminLTE.css',
        'css/dist/skins/_all-skins.min.css',		
        'plugins/iCheck/flat/blue.css',		
        'css/site.css',
        'css/print.css',
    ];
    public $js = [
		//'//code.jquery.com/ui/1.11.4/jquery-ui.min.js',
		'js/bootstrap/bootstrap.min.js',
		'//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',
		'plugins/sparkline/jquery.sparkline.min.js',
		'plugins/slimScroll/jquery.slimscroll.min.js',
		'plugins/chartjs/Chart.min.js',
		//'plugins/jQuery/jQuery-2.2.0.min.js',
		//'plugins/jQueryUI/jquery-ui.min.js',
		'plugins/fastclick/fastclick.min.js',
		'js/dist/demo.js',
		//'js/pages/dashboard.js',
		'js/main.js',
		'js/dist/app.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
