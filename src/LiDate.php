<?php

namespace Lit\Utils;

/**
 * liDate: PHP 日期时间补充部分
 * @author  litong
 * @since   1.0
 **/
class LiDate
{

    /**
     * microTime
     * 返回当前时间以秒为单位的微秒数
     * @access public
     * @return string
     * @since  1.0
     */
    public static function microTime() {
        return sprintf("%f", microtime(true));
    }

    /**
     * milliTime
     * 返回当前时间以秒为单位的毫秒数
     * @access public
     * @return string
     * @since  1.0
     */
    public static function milliTime() {
        return sprintf("%.3f", microtime(true));
    }

    /**
     * dateFormat
     * 返回中文格式化的时间
     * @access public
     * @param int $ts 要格式化的时间戳
     * @return string
     * @since  1.0
     */
    public static function dateFormat($ts) {
        if (!is_numeric($ts)) {
            return '';
        }
        $PassTime = time() - $ts;
        $Format = [
            ['s' => -PHP_INT_MAX, 'e' => 0, 'msg' => '将来'],
            ['s' => 0, 'e' => 60, 'msg' => '刚刚'],
            ['s' => 60, 'e' => 3600, 'msg' => floor($PassTime / 60) . '分钟前'],
            ['s' => 3600, 'e' => 86400, 'msg' => floor($PassTime / 3600) . '小时前'],
            ['s' => 86400, 'e' => 2592000, 'msg' => floor($PassTime / 86400) . '天前'],
            ['s' => 2592000, 'e' => 31536000, 'msg' => floor($PassTime / 2592000) . '月前'],
            ['s' => 31536000, 'e' => PHP_INT_MAX, 'msg' => floor($PassTime / 31536000) . '年前'],
        ];
        foreach ($Format as $val) {
            if ($val['s'] <= $PassTime && $PassTime < $val['e']) {
                return $val['msg'];
            }
        }
        return '';
    }

    /**
     * nextMonth
     * 返回下个月是几月
     * @access public
     * @param string $date
     * @param string $format
     * @return string
     * @since  1.0
     */
    public static function nextMonth($date = '', $format = 'Y-m') {
        if ($date == '') {
            $date = date('Y-m-d');
        }
        $ts = strtotime(date("Y-m-25", strtotime($date))) + 3600 * 24 * 10;
        return date($format, $ts);
    }

    /**
     * lastMonth
     * 返回上个月是几月
     * @access public
     * @param string $date
     * @param string $format
     * @return string
     * @since  1.0
     */
    public static function lastMonth($date = '', $format = 'Y-m') {
        if ($date == '') {
            $date = date('Y-m-d');
        }
        $ts = strtotime(date("Y-m-01", strtotime($date))) - 3600 * 24 * 10;
        return date($format, $ts);
    }

    /**
     * todayRemainTime
     * 返回今天还剩多少秒
     * @access public
     * @return string
     * @since  1.0
     */
    public static function todayRemainTime() {
        return strtotime(date('Y-m-d') . ' 24:00:00') - time();
    }

}