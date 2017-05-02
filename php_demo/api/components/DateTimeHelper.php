<?php
/**
 * Created by PhpStorm.
 * User: leipeng
 * Date: 12/25/14
 * Time: 1:52 PM
 */

namespace api\components;


class DateTimeHelper {
    /*
     * 获取当前时间
     */
    public static function now($format='Y-m-d H:i:s'){
        return date($format);
    }

    /*
     * 将时间戳转换为当前时间string
     */
    public static function  timeToDate($time,$format = 'Y-m-d H:i:s')
    {
        return date($format,$time);
    }
} 