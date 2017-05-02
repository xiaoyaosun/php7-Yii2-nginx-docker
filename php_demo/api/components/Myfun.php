<?php

namespace api\components;

use Yii;

// 引入curl库
use api\components\Mycurl;

//define(DEBUG_LOG, '/opt/logs/debug/Myfun-'.date('Y-m-d', time()).'.log');

class Myfun
{
	// 检查参数key是否为空
	public static function checkEmptyKey($param, $arrMust, $print=true){
		if ( ! is_array($param) ) {
			//Log::warning('param is not array');
			return 'checkEmptyKey - param';
		}
		foreach ($arrMust as $key) {
			if (! array_key_exists($key, $param)) {
				//if ($print) {
				//	Log::warning("param $key not exists");
				//}
				return $key;
			}
			if ( '' === $param[$key] ) {
				//if ($print) {
				//	Log::warning("$key 's value can't be empty");
				//}
				return $key;
			}
		}
		return '';
	}

	// 检查参数值是否为空
	public static function checkEmptyValue($param, $arrMust, $print=true){
		if ( ! is_array($param) ) {
			//Log::warning('param is not array');
			return 'checkEmptyKey - param';
		}
		foreach ($arrMust as $key) {
			if (! array_key_exists($key, $param)) {
				//if ($print) {
				//	Log::warning("param $key not exists");
				//}
				return $key;
			}
			if ( '' === $param[$key] || null === $param[$key]) {
				//if ($print) {
				//	Log::warning("$key 's value can't be empty");
				//}
				return $key;
			}
		}
		return '';
	}

	// 生成验证码
	public static function generate_code($length = 4) {
		return rand(pow(10,($length-1)), pow(10,$length)-1);
	}

	// 判断
	// 入参
	// curl_res
	// curl_err
	public static function checkCurlStatus($curl_info) {

		$ret = array();

		// curl_err返回非0时，判断有问题，并记录错误
		if (!empty($curl_info['curl_err'])) {
			
			$ret['error_code'] = 109;
			$ret['error_msg'] = 'curl失败';
			$ret['data']['curl_err'] = $curl_info['curl_err']; // int型
		} else {
			
			$ret['error_code'] = 0;
			$ret['error_msg'] = '';
		}

		return $ret;
	}
	
	// 验证返回值是否成功
	public static function checkRet($res) {

		if (empty($res['error_code'])) {
			
			return true;
		} else {
			
			return false;
		}
		
	}
	
	// 利用microtime生成uuid
	public static function generateUUID()
	{
		list($usec, $sec) = explode(" ", microtime());
		
		list($a, $b) = explode(".", $usec);
		return array('long' => $sec.$b, 'short' => $sec);
	}
	
	// 计算中文字符串长度
	public static function utf8_strlen($string = null) {
		
		// 将字符串分解为单元
		preg_match_all("/./us", $string, $match);

		// 返回单元个数
		return count($match[0]);
	}
	
	// 利用microtime生成日志的参数
	public static function generateLogTime()
	{
		return '['.microtime(true).']';
	}
	
	/**
	 * 除去数组中的空值和签名参数
	 * @param $para 签名参数组
	 * return 去掉空值与签名参数后的新签名参数组
	 */
	public static function paraFilter($para) {
		$para_filter = array();
		while (list ($key, $val) = each ($para)) {
			if($key == "sign" || $key == "sign_type" || $val == "")continue;
			else	$para_filter[$key] = $para[$key];
		}
		return $para_filter;
	}

	/**
	 * 对数组排序
	 * @param $para 排序前的数组
	 * return 排序后的数组
	 */
	public static function argSort($para) {
		ksort($para);
		reset($para);
		return $para;
	}
	
	/**
	 * 把数组所有元素，按照“参数参数值”的模式用拼接成字符串
	 * 用于三滴水，火车票查询
	 * @param $para 需要拼接的数组
	 * return 拼接完成以后的字符串
	 */
	public static function createLinkstringbysds($para) {
		$arg  = "";
		while (list ($key, $val) = each ($para)) {
			$arg.=$val;
		}
		
		//如果存在转义字符，那么去掉转义
		if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
		
		return $arg;
	}
	
	/**
	 * 把数组所有元素，按照“参数参数值”的模式用拼接成字符串
	 * @param $para 需要拼接的数组
	 * return 拼接完成以后的字符串
	 */
	public static function createLinkstring($para) {
		$arg  = "";
		while (list ($key, $val) = each ($para)) {
			$arg.=$key.$val;
		}
		
		//如果存在转义字符，那么去掉转义
		if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
		
		return $arg;
	}

	/**
	 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
	 * @param $para 需要拼接的数组
	 * return 拼接完成以后的字符串
	 */
	public static function createBusLinkstring($para) {
		$arg  = "";
		while (list ($key, $val) = each ($para)) {
			$arg.=$key."=".$val."&";
		}
		//去掉最后一个&字符
		$arg = substr($arg,0,count($arg)-2);
		
		//如果存在转义字符，那么去掉转义
		if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
		
		return $arg;
	}
	
	// 检查default值，并返回正确的默认值
	public static function checkDefaultValue($data) {
		
		if (isset($data)) {			
			return ($data === null) ? '' : $data;
		} else {
			return '';
		}
	}

	/**
	 * 验证18位身份证
	 * @param  string $id 身份证
	 * return boolean
	 */
	public static function check_identity($id='')
	{
	    $set = array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);
	    $ver = array('1','0','x','9','8','7','6','5','4','3','2');
	    $arr = str_split($id);
	    $sum = 0;
	    for ($i = 0; $i < 17; $i++)
	    {
	        if (!is_numeric($arr[$i]))
	        {
	            return false;
	        }
	        $sum += $arr[$i] * $set[$i];
	    }
	    $mod = $sum % 11;
	    if (strcasecmp($ver[$mod],$arr[17]) != 0)
	    {
	        return false;
	    }
	    return true;
	}

	/**
	 * 验证9为手机号码
	 * @param  string $phonenumber
	 * return boolean
	 */
	public static function  check_phone($phonenumber)
	{
		//目前只验证11位手机号是数字
		if(preg_match("/\d{11}$/",$phonenumber)) {		     
		   return true;
		}else{  		   
			return false;		   
		}
		//if(preg_match("/1[3458]{1}\d{9}$/",$phonenumber)) {		     
		//   return true;
		//}else{  		   
		//	return false;		   
		//}
	}

	//获取星期方法
    public static function get_week($date){
        //强制转换日期格式
        $date_str=date('Y-m-d',strtotime($date));   
        //封装成数组
        $arr=explode("-", $date_str);        
        //参数赋值
        //年
        $year=$arr[0];       
        //月，输出2位整型，不够2位右对齐
        $month=sprintf('%02d',$arr[1]);        
        //日，输出2位整型，不够2位右对齐
        $day=sprintf('%02d',$arr[2]);        
        //时分秒默认赋值为0；
        $hour = $minute = $second = 0;   
        //转换成时间戳
        $strap = mktime($hour,$minute,$second,$month,$day,$year);
        //获取数字型星期几
        $number_wk=date("w",$strap);       
        //自定义星期数组
        $weekArr=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");      
        //获取数字对应的星期
        return $weekArr[$number_wk];
    }
    
	/*
	function:二维数组按指定的键值排序
	author:www.111cn.net
	*/
    public static function array_sort($array, $keys, $type = 'asc')
    {
        if (!isset($array) || !is_array($array) || empty($array)) {
            return '';
        }
        if (!isset($keys) || trim($keys) == '') {
            return '';
        }
        if (!isset($type) || $type == '' || !in_array(strtolower($type), array('asc', 'desc'))) {
            return '';
        }
        $keysvalue = array();
        foreach ($array as $key => $val) {
            $val[$keys] = str_replace('-', '', $val[$keys]);
            $val[$keys] = str_replace(' ', '', $val[$keys]);
            $val[$keys] = str_replace(':', '', $val[$keys]);
            $keysvalue[] = $val[$keys];
        }
        asort($keysvalue); //key值排序
        reset($keysvalue); //指针重新指向数组第一个
        foreach ($keysvalue as $key => $vals) {
            $keysort[] = $key;
        }
        $keysvalue = array();
        $count = count($keysort);
        if (strtolower($type) != 'asc') {
            for ($i = $count - 1; $i >= 0; $i--) {
                $keysvalue[] = $array[$keysort[$i]];
            }
        } else {
            for ($i = 0; $i < $count; $i++) {
                $keysvalue[] = $array[$keysort[$i]];
            }
        }
        return $keysvalue;
    }
    
	/**
     * 对多位数组进行排序
     * @param $multi_array 数组
     * @param $sort_key需要传入的键名
     * @param $sort排序类型
     */
    public static function multi_array_sort($multi_array, $sort_key, $sort = SORT_DESC) {
        if (is_array($multi_array)) {
            foreach ($multi_array as $row_array) {
                if (is_array($row_array)) {
                    $key_array[] = $row_array[$sort_key];
                } else {
                    return FALSE;
                }
            }
        } else {
            return FALSE;
        }
        array_multisort($key_array, $sort, $multi_array);
        return $multi_array;
    }
    
	/**
	 * 获取header中的往返参数
	 */
	public static function getHeaderInfo()
	{
		// 获取header中的往返参数
		$header = array();
		$header['product'] = self::checkDefaultValue($_SERVER['HTTP_PRODUCT']);
		$header['channel'] = self::checkDefaultValue($_SERVER['HTTP_CHANNEL']);
		$header['sysver'] = self::checkDefaultValue($_SERVER['HTTP_SYSVER']);
		$header['appver'] = self::checkDefaultValue($_SERVER['HTTP_APPVER']);
		$header['deviceID'] = self::checkDefaultValue($_SERVER['HTTP_DEVICE_ID']);
		$header['deviceSn'] = self::checkDefaultValue($_SERVER['HTTP_DEVICE_SN']);
		$header['screenWidth'] = self::checkDefaultValue($_SERVER['HTTP_SCREEN_WIDTH']);
		$header['screenHeight'] = self::checkDefaultValue($_SERVER['HTTP_SCREEN_HEIGHT']);
		
		return $header;
	}
    /**
     * 比较版本号
     * @param $t_version
     * @param $p_version
     */
    public static function compareVersion($t_version, $p_version,$equal_true=false){
        $update_flag = false;
        if($equal_true&&$t_version==$p_version){
            return true;
        }
        //按‘.’分割成数组
        $t_version = explode('.', $t_version);
        $p_version = explode('.', $p_version);
        //比较第一个数
        if($t_version[0] > $p_version[0]){
            $update_flag = true;
        }else if($t_version[0] == $p_version[0]){
            //比较第二个数
            //是否有0
            if(strpos($t_version[1], '0') === 0 || strpos($p_version[1], '0') === 0){
                $t_version1_trim = ltrim($t_version[1], '0');
                $t_version1_delta = strlen($t_version[1]) - strlen($t_version1_trim);
                $p_version1_trim = ltrim($p_version[1], '0');
                $p_version1_delta = strlen($p_version[1]) - strlen($p_version1_trim);
                if($t_version1_delta < $p_version1_delta){
                    $update_flag = true;
                }else{
                    //比较第三个数
                    //是否有0
                    if(strpos($t_version[2], '0') === 0 || strpos($p_version[2], '0') === 0){
                        $t_version2_trim = ltrim($t_version[2], '0');
                        $t_version2_delta = strlen($t_version[2]) - strlen($t_version2_trim);
                        $p_version2_trim = ltrim($p_version[2], '0');
                        $p_version2_delta = strlen($p_version[2]) - strlen($p_version2_trim);
                        if($t_version2_delta < $p_version2_delta){
                            $update_flag = true;
                        }
                    }else{
                        if($t_version[2] > $p_version[2]){
                            $update_flag = true;
                        }
                    }
                }
            }else{
                if($t_version[1] > $p_version[1]){
                    $update_flag = true;
                }else if($t_version[1] == $p_version[1]){
                    //比较第三个数
                    //是否有0
                    if(strpos($t_version[2], '0') === 0 || strpos($p_version[2], '0') === 0){
                        $t_version2_trim = ltrim($t_version[2], '0');
                        $t_version2_delta = strlen($t_version[2]) - strlen($t_version2_trim);
                        $p_version2_trim = ltrim($p_version[2], '0');
                        $p_version2_delta = strlen($p_version[2]) - strlen($p_version2_trim);
                        if($t_version2_delta < $p_version2_delta){
                            $update_flag = true;
                        }
                    }else{
                        if($t_version[2] > $p_version[2]){
                            $update_flag = true;
                        }
                    }
                }
            }
        }
        return $update_flag;
    }

    /**change db data to array
     * @param $t_data
     * @return mixed
     */
    public static function changeDbDataToArr($t_data){
        if($t_data){
            if(count($t_data)==1){
                $data =$t_data->attributes;
            }else{
                foreach($t_data as $item){//=二维数组
                    $item_new =$item->attributes;
                    $data[] =$item_new;
                }
            }
            return $data;
        }
    }

	
	// 权重数值越高，被返回的概率越大
	//$data=array(
	// 0=>array('id'=>1,'name'=>'一等奖','weight'=>'5'),
	// 1=>array('id'=>2,'name'=>'二等奖','weight'=>'10'),
	// 2=>array('id'=>3,'name'=>'三等奖','weight'=>'25'),
	// 3=>array('id'=>4,'name'=>'谢谢抽奖','weight'=>'60')
	//);
	public static function countWeight($data) {
		$weight=0;
		$temp=array();
		foreach($data as $v) {
		    if($v['weight']!='0'){
                $weight+=$v['weight'];
                for($i=0;$i<$v['weight'];$i++) {
                    $temp[]=$v;//放大数组
                }
            }
		}
		$int=mt_rand(0,$weight-1);//获取一个随机数
		$result=$temp[$int];
		return $result;
	}

    /** whether a value in multi-array
     * @param $value
     * @param $array
     * @return bool
     */
    public static function deepInArray($value, $array) {
        foreach($array as $item) {
            if(!is_array($item)) {
                if ($item == $value) {
                    return true;
                } else {
                    continue;
                }
            }
            if(in_array($value, $item)) {
                return true;
            } else if(self::deepInArray($value, $item)) {
                return true;
            }
        }
        return false;
    }

    /**在数组中去除或提取key_value,返回数组
     * @param $array
     * @param $keyArr
     * @return mixed
     */
    public static function extractSpecificKeyValFromArray($array, $keyAddArr,$keyDelArr){
        if($array&&is_array($array)){
            if($keyDelArr){
                foreach($keyDelArr as $key){
                    unset($array[$key]);
                }
            }
            if($keyAddArr){
                $new_array =array();
                foreach($keyAddArr as $key){
                    $new_array[$key] = $array[$key];
                }
                return $new_array;
            }
        }
        return $array;
    }

}