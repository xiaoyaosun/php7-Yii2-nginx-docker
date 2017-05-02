<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');
define('BASE_PATH',str_replace('\\','/',realpath(dirname(__FILE__).'/'))."/");

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');
require(__DIR__ . '/../../common/components/globals.php');


$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../../common/config/main-local.php'),
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../config/main-local.php')
);


error_reporting(E_ALL & ~E_NOTICE);

require(__DIR__ . '/../components/WKStaclient.php');
list($msec, $sec) = explode(" ", microtime());
$index_date = date("Y-m-d H:i:s",$sec);
$index_time=$index_date.".".($msec*100000000).mt_rand(00000,99999);
define('UNIQUE_ID',$index_time);


$application = new yii\web\Application($config);
$application->run();

