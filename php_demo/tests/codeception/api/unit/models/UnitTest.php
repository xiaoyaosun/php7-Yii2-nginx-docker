<?php

namespace tests\codeception\api\unit\models;

use Yii;
use tests\codeception\api\unit\TestCase;
use api\modules\v1\logic\L_site;

//引入components
//use api\components\Mycurl;
//use api\components\Myfun;

/**
 * API的单元测试
 */
class UnitTest extends TestCase {
	
	use \Codeception\Specify;	// 要先在这里use一下

	// randTest 测试
	public function testRand() {

		//$url = 'http://localhost:8087/api/web/v1/site/randtest?param={"platform":"web"}';
		//$array = array('platform' => 'web');
		//$url = ROOT_URL_API . 'api/web/v1/site/randtest?param=' . json_encode($array);
		//$result = file_get_contents($url);
		//$resultAray = json_decode($result, true);
		
		$resultAray = L_site::randTest();
		if(isset($resultAray['error_code']) and $resultAray['error_code'] == 0 ) {
			codecept_debug("Pass!");
		}else{
			$this->assertTrue(false, $resultAray['error_msg']);
		}
    }
}
