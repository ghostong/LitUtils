<?php 

namespace Lit\Litool;

/**
 * lidate: litool PHP 日期时间部分
 * @author  litong
 * @since   1.0
 **/

class LiDate {
    
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
     * @return string
     **/
    public static function MicroTime (){
        return sprintf( "%f", microtime (true) );
    }

    /** 
     * MilliTime
     * 返回当前时间以秒为单位的毫秒数
     * @access public
     * @since  1.0 
     * @return string
     **/
    public static function MilliTime (){
        return sprintf( "%.3f", microtime (true) );
    }

    /** 
     * DateFormat
     * 返回中文格式化的时间
     * @access public
     * @param  mixed $ts 要格式化的时间戳
     * @since  1.0 
     * @return string
     **/
     public static function DateFormat ( $ts ){
         if ( !is_numeric ( $ts ) ) {
             return '';
         }
         $PassTime = time()-$ts;
         $Format = array (
             array ( 's' => -PHP_INT_MAX , 'e' => 0          , 'msg' => '将来'  ),
             array ( 's' => 0            , 'e' => 60         , 'msg' => '刚刚'  ),
             array ( 's' => 60           , 'e' => 3600       , 'msg' => floor ($PassTime/60)       .'分钟前'),
             array ( 's' => 3600         , 'e' => 86400      , 'msg' => floor ($PassTime/3600)     .'小时前'),
             array ( 's' => 86400        , 'e' => 2592000    , 'msg' => floor ($PassTime/86400)    .'天前'  ),
             array ( 's' => 2592000      , 'e' => 31536000   , 'msg' => floor ($PassTime/2592000)  .'月前'  ),
             array ( 's' => 31536000     , 'e' => PHP_INT_MAX, 'msg' => floor ($PassTime/31536000) .'年前'  ),
         );
         foreach ( $Format as $val ) {
             if ( $val['s'] <= $PassTime && $PassTime < $val['e']) {
                 return $val['msg'];
             }
         }
        return '';
     }

    /** 
     * NextMonth
     * 返回下个月是几月
     * @access public
     * @param  string $date
     * @param  string $format
     * @since  1.0 
     * @return string
     **/
    public static function NextMonth ( $date='', $format='Y-m' ){
        if($date == ''){
            $date = date( 'Y-m-d' );
        }
        $ts = strtotime ( date( "Y-m-25",strtotime($date) ) )+ 3600*24*10;
        return date($format,$ts);
    }

    /** 
     * LastMonth
     * 返回上个月是几月
     * @access public
     * @param  string $date
     * @param  string $format
     * @since  1.0 
     * @return string
     **/
    public static function LastMonth ( $date='',$format='Y-m' ){
        if($date == ''){
            $date = date( 'Y-m-d' );
        }
        $ts = strtotime ( date( "Y-m-01",strtotime($date) ) ) - 3600*24*10;
        return date($format,$ts);
    }

    /** 
     * TodayRemainTime
     * 返回今天还剩多少秒
     * @access public
     * @since  1.0 
     * @return string
     **/
    public static function TodayRemainTime (){
        return strtotime( date('Y-m-d').' 24:00:00' ) - time();
    }

}
