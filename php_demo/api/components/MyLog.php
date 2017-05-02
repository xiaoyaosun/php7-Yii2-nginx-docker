<?php
/**
 * Created by PhpStorm.
 * Date: 2016/9/1
 * Time: 14:27
 */

namespace api\components;


class MyLog
{
    private static $debug = true;
//    public static $logArr = array();
    public static $logByFileArr = array();
    public static $logFormatFileArr = array();
    public static $logErrorArr = array();
    //普通日志
    //先简单处理，最后实现更高级功能，比如自动识别controller和action，行数等等
    /* public static function log($content)
     {
         if ($content) {
             self::$logArr[] =UNIQUE_ID .'-'. $content . "\n";
         }
     }*/

    public static function log( $content)
    {
        if ($content) {
            $backtraceArr = debug_backtrace();
            if ($backtraceArr && isset($backtraceArr[1])) {
                $temp = explode("\\",$backtraceArr[1]['class']);
                $fileName = end($temp);
                $function = $backtraceArr[1]['function'];
            }
            if (!isset(self::$logByFileArr[$fileName])) {
                self::$logByFileArr[$fileName] = array();
            }
            self::$logByFileArr[$fileName][] = UNIQUE_ID . "-".$function ."-". $content ."\n";

        }
    }
    public static function logFormatForElastic($var_name,$content)
    {
        if ($content) {
            $backtraceArr = debug_backtrace();
            if ($backtraceArr && isset($backtraceArr[1])) {
                $temp = explode("\\",$backtraceArr[1]['class']);
                $fileName = end($temp);
                $function = $backtraceArr[1]['function'];
            }
            if (!isset(self::$logFormatFileArr[$fileName])) {
                self::$logFormatFileArr[$fileName] = array();
            }
            if(is_array($content)){
                $data['content'] = json_encode($content);
            }else{
                $data['content'] =$content;
            }
            $data['unique_id'] = UNIQUE_ID;
            $data['function'] = $function;
            $data['var_name'] = $var_name;
            self::$logFormatFileArr[$fileName][] = json_encode($data)."\n";
        }
    }
   /* public static function logFormatSpecFileForElastic($fileName,$var_name,$content)
    {
        if ($content) {
            $backtraceArr = debug_backtrace();
            if ($backtraceArr && isset($backtraceArr[1])) {
                $temp = explode("\\",$backtraceArr[1]['class']);
//                $fileName = end($temp);
                $function = $backtraceArr[1]['function'];
            }
            if (!isset(self::$logFormatFileArr[$fileName])) {
                self::$logFormatFileArr[$fileName] = array();
            }
            $data['unique_id'] = UNIQUE_ID;
            $data['function'] = $function;
            $data['var_name'] = $var_name;
            $data['content'] = $content;
            self::$logFormatFileArr[$fileName][] = json_encode($data)."\n";
        }
    }*/
    //指定output filename
    public static function logSpec($fileName,$content){
        if ($content) {
            if (!isset(self::$logByFileArr[$fileName])) {
                self::$logByFileArr[$fileName] = array();
            }
            self::$logByFileArr[$fileName][] = UNIQUE_ID  ."-". $content ."\n";

        }
    }

    //严重错误日志
    public static function logError($content)
    {
        if ($content) {
            $backtraceArr = debug_backtrace();
            if ($backtraceArr && isset($backtraceArr[1])) {
                $temp = explode("\\",$backtraceArr[1]['class']);
                $fileName = end($temp);
                $function = $backtraceArr[1]['function'];
            }
            if (!isset(self::$logErrorArr[$fileName])) {
                self::$logErrorArr[$fileName] = array();
            }
            self::$logErrorArr[$fileName][] = UNIQUE_ID . "-".$function ."-". $content ."\n";
        }
    }

    //请求周期结束后调用
    public static function logEnd()
    {
        if (self::$debug) {
            /*if (self::$logArr) {
                file_put_contents('/opt/logs/debug/' . date('Y-m-d', time()) . '.log', implode('', self::$logArr), FILE_APPEND);
            }*/
            if (self::$logByFileArr) {
                foreach (self::$logByFileArr as $key => $logByFile) {
                    file_put_contents('/opt/logs/debug/--' . $key . '--' . date('Y-m-d', time()) . '.log', implode('', $logByFile), FILE_APPEND);
                }
            }
            if (self::$logErrorArr) {
                foreach (self::$logErrorArr as $key => $logByFile) {
                    file_put_contents('/opt/logs/debug/--' . $key . 'error--' . date('Y-m-d', time()) . '.log', implode('', $logByFile), FILE_APPEND);
                }
            }
            if (self::$logFormatFileArr) {
                foreach (self::$logFormatFileArr as $key => $logByFile) {
                    file_put_contents('/opt/logs/debug/'.'elastic_' . $key  . date('Y-m-d', time()) . '.log', implode('', $logByFile), FILE_APPEND);
                }
            }
        }


    }

}