<?php 

namespace lit\litool;

/**
 * lidate: litool PHP 日期时间部分
 * @author  litong
 * @since   1.0
 **/

class lidate {

    /** 
     * init
     * 测试调用
     * @access public
     * @since  1.0 
     * @return string
     **/   
    public static function init (){
        $PreStr = __CLASS__.'::'.__FUNCTION__;
        return $PreStr.' success';
    }

    /** 
     * MicroTime
     * 返回当前时间以秒为单位的微秒数
     * @access public
     * @since  1.0 
     * @return array
     **/
    public static function MicroTime () {
        return sprintf( "%f", microtime (true) );
    }

    /** 
     * MilliTime
     * 返回当前时间以秒为单位的毫秒数
     * @access public
     * @since  1.0 
     * @return array
     **/
    public static function MilliTime(){
        return sprintf( "%.3f", microtime (true) );
    }

}
