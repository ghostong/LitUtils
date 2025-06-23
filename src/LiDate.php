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
     * @param int $timestamp 要格式化的时间戳
     * @return string
     * @since  1.0
     */
    public static function dateFormat($timestamp) {
        if (!is_numeric($timestamp)) {
            return '';
        }
        $passTime = time() - $timestamp;
        $format = [
            ['s' => -PHP_INT_MAX, 'e' => 0, 'msg' => '将来'],
            ['s' => 0, 'e' => 60, 'msg' => '刚刚'],
            ['s' => 60, 'e' => 3600, 'msg' => floor($passTime / 60) . '分钟前'],
            ['s' => 3600, 'e' => 86400, 'msg' => floor($passTime / 3600) . '小时前'],
            ['s' => 86400, 'e' => 2592000, 'msg' => floor($passTime / 86400) . '天前'],
            ['s' => 2592000, 'e' => 31536000, 'msg' => floor($passTime / 2592000) . '月前'],
            ['s' => 31536000, 'e' => PHP_INT_MAX, 'msg' => floor($passTime / 31536000) . '年前'],
        ];
        foreach ($format as $val) {
            if ($val['s'] <= $passTime && $passTime < $val['e']) {
                return $val['msg'];
            }
        }
        return '';
    }

    /**
     * nextMonth
     * 返回指定时间, 下个月是几月
     * @access public
     * @param string $date 2021-01-28
     * @param string $format Y-m 或 m
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
     * nextDay
     * 返回指定日期时间, 第二天的日期
     * @date 2022/4/18
     * @param string $dateTime 指定的日期时间
     * @param string $format Y-m-d 或 Y-m-d H:i:s 等
     * @return false|string
     * @since  1.0
     */
    public static function nextDay($dateTime, $format = 'Y-m-d H:i:s') {
        return date($format, strtotime($dateTime) + 3600 * 24);
    }

    /**
     * nextTime
     * 返回指定时间, 下一个指定时间
     * @date 2022/4/18
     * @param string $time 指定的时间 22:11:33
     * @param string $format Y-m-d 或 Y-m-d H:i:s 等
     * @return false|string
     * @since  1.0
     */
    public static function nextTime($time, $format = 'Y-m-d H:i:s') {
        $now = time();
        $time = $time ?: date("H:i:s", $now + 1);
        $time = substr($time, -8);
        $nowTime = date("H:i:s", $now);
        if ($nowTime >= $time) {
            $ts = self::nextDay(date("Y-m-d"), "Y-m-d") . " " . $time;
        } else {
            $ts = date("Y-m-d") . " " . $time;
        }
        return date($format, strtotime($ts));
    }

    /**
     * lastMonth
     * 返回上个月是几月
     * @access public
     * @param string $date 2021-01-28
     * @param string $format Y-m 或 Y
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
     * @return int
     * @since  1.0
     */
    public static function todayRemainTime() {
        return strtotime(date('Y-m-d') . ' 24:00:00') - time();
    }

    /**
     * monthFirstDay
     * 返回本月的第一天
     * @access public
     * @param string $date
     * @param string $format
     * @return string
     * @since  1.0
     */
    public static function monthFirstDay($date = '', $format = 'Y-m-d') {
        return date($format, strtotime(date("Y-m-01", strtotime($date))));
    }

    /**
     * monthLastDay
     * 返回本月的最后一天
     * @access public
     * @param string $date
     * @param string $format
     * @return string
     * @since  1.0
     */
    public static function monthLastDay($date = '', $format = 'Y-m-d') {
        return date($format, strtotime(date("Y-m-t", strtotime($date))));
    }

    /**
     * reFormat
     * 重新格式化时间
     * @access public
     * @param string $date
     * @param string $format
     * @return string
     * @since  1.0
     */
    public static function reFormat($date, $format = 'Y-m-d H:i:s') {
        return date($format, strtotime($date));
    }

    /**
     * validateFormat
     * 验证时间格式
     * @access public
     * @param string $date
     * @param string $format
     * @return boolean
     * @since  1.0
     */
    public static function validateFormat($date, $format = 'Y-m-d H:i:s'){
        $dtObj = date_create_from_format($format, $date);
        return $dtObj && date_format($dtObj, $format) === $date;
    }
}