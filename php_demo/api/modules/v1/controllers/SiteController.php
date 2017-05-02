<?php

namespace api\modules\v1\controllers;
//use api\components\Mycurl;
use api\components\Myfun;

use Yii;

// 引入DB模型
//use api\modules\v1\models\M_site;

// redis
//use yii\redis\Connection;

// 引入LOG记录
//use api\components\YQTracer;

// 引入Logic模型
use api\modules\v1\logic\L_site;

// 引入统计模块
use api\components\WKStaclient;

define(DEBUG_LOG, '/opt/logs/debug/SiteController-'.date('Y-m-d', time()).'.log');

class SiteController extends \yii\web\Controller
{
	
	// 禁用csrf
	// post表单会默认添加校验
	public $enableCsrfValidation = false;
	
	// 随机数带权重的测试
    public function actionRandtest()
    {
		
        $module = str_replace("\\", '_', __CLASS__);
        WKStaclient::tick($module, __FUNCTION__);
		
		$ret = array();
		$ret['error_code'] = 0;
		$ret['error_msg'] = '';
		$ret['data'] = '';

		$param = json_decode($_REQUEST['param'], true);
		if (empty($param)) {
			
			// 有字段为空，参数错误
			$ret['error_code'] = 100;
			$ret['error_msg'] = '参数错误';
		} else {
			if (Myfun::checkEmptyKey($param, array('platform')) !== '') {
				
				// 有字段为空，参数错误
				$ret['error_code'] = 100;
				$ret['error_msg'] = '参数错误';
				
			} else {
				
				$ret = L_site::randTest();
			}
		}
		if (!is_array($ret)) {
			$ret = array();
			$ret['error_code'] = 99;
			$ret['error_msg'] = '服务器开小差';
			$ret['data'] = '';
		}
		
		WKStaclient::report($module, __FUNCTION__, 1, 0, 'ok');
		
		// H5调用会有跨域问题，因此当H5调用传递callback参数时，另作处理
		if (isset($_REQUEST['callback']) and !empty($_REQUEST['callback'])) {
			echo $_REQUEST['callback'].'('.json_encode($ret).')';
		} else {
			
			echo json_encode($ret);
		}
    }
}
