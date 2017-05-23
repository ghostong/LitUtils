<?php 

namespace lit\litool;

/**
 * lisundry: litool PHP 杂项部分
 * @author  litong
 * @since   1.0
 **/

class lisundry {
    
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
     * RemoteAddr
     * 获取用户来源IP
     * @access public
     * @since  1.0 
     * @return string
     **/
    public static function GetRemoteAddr (){
        static $ip  =   NULL;
        if ( $ip !== NULL ) {
            return $ip;
        }
        if ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
            $arr = explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] );
            $pos = array_search( 'unknown', $arr );
            if( false !== $pos ) {
                unset( $arr[$pos] );
            }
            $ip = trim( $arr[0] );
        } elseif ( isset($_SERVER['HTTP_CLIENT_IP']) ) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif ( isset($_SERVER['REMOTE_ADDR']) ) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $long = sprintf( "%u",ip2long($ip) );  // IP地址合法验证
        $ip   = $long ? $ip : '0.0.0.0';
        return $ip;
    }


}
