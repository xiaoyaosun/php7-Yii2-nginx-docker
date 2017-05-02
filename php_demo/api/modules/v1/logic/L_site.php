<?php

namespace api\modules\v1\logic;

use api\components\Myfun;

class L_site {
	
    public static function randTest(){
        
		$ret['error_code'] = 0;
        $ret['error_msg'] = '';
        
		$data=array(
			0=>array('id'=>1,'name'=>'一等奖','weight'=>'5'),
			1=>array('id'=>2,'name'=>'二等奖','weight'=>'20'),
			2=>array('id'=>3,'name'=>'三等奖','weight'=>'50'),
			3=>array('id'=>4,'name'=>'谢谢抽奖','weight'=>'100'),
		);
		
		$ret['data']['wight'] = Myfun::countWeight($data);
        return $ret;
    }
}