<?php 

namespace Lit\Utils;

/**
 * liSundry: litool PHP 杂项部分
 * @author  litong
 * @since   1.0
 **/

class LiSundry {
    
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
    public static function getRemoteAddr (){
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

    /** 
     * sendHttpStatus
     * 发送http状态码
     * @access public
     * @param  int $code  Http状态码
     * @since  1.0
     **/
    public static function sendHttpStatus( $code ) {
        static $status = array(
            100 => 'Continue', 101 => 'Switching Protocols',
            200 => 'OK', 201 => 'Created', 202 => 'Accepted', 203 => 'Non-Authoritative Information', 204 => 'No Content', 205 => 'Reset Content', 206 => 'Partial Content',
            300 => 'Multiple Choices', 301 => 'Moved Permanently', 302 => 'Moved Temporarily ', 303 => 'See Other', 304 => 'Not Modified', 305 => 'Use Proxy', 306 => 'Switch Proxy', 307 => 'Temporary Redirect',
            400 => 'Bad Request', 401 => 'Unauthorized', 402 => 'Payment Required', 403 => 'Forbidden', 404 => 'Not Found', 405 => 'Method Not Allowed', 406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required', 408 => 'Request Timeout', 409 => 'Conflict', 410 => 'Gone', 411 => 'Length Required', 412 => 'Precondition Failed', 
            413 => 'Request Entity Too Large', 414 => 'Request-URI Too Long', 415 => 'Unsupported Media Type', 416 => 'Requested Range Not Satisfiable', 417 => 'Expectation Failed',
            500 => 'Internal Server Error', 501 => 'Not Implemented', 502 => 'Bad Gateway', 503 => 'Service Unavailable', 504 => 'Gateway Timeout', 505 => 'HTTP Version Not Supported', 509 => 'Bandwidth Limit Exceeded'
        );
        if(isset($status[$code])) {
            header('HTTP/1.1 '.$code.' '.$status[$code]);
            header('Status:'.$code.' '.$status[$code]);
        }
    }

    /** 
     * getWeight
     * 根据权重随机返回被选数据
     * @access public
     * @param  array $wd  Http状态码
     * @since  1.0 
     * @return mixed
     **/
    public static function getWeight( $wd ){
        $temp = array();
        $weight = 0;
        foreach ( $wd as $val ) {
            $w = $val['w'];
            $weight += $w;
            for ( $i =0 ; $i<$w ; $i++ ) {
                $temp[] = $val['v'];
            }
        }
        $r = mt_rand( 0, $weight-1 );
        shuffle ( $temp );
        return $temp[$r];
    }

    /** 
     * isLocalIp
     * 判断是否私网IP
     * @access public
     * @param  string $IP  要判断的IP
     * @since  1.0 
     * @return boolean
     **/
    public static function isLocalIp( $IP ){
        $LongIp = ip2long($IP);
        $IPArr = array(
            array('s' => '10.0.0.0'   , 'e' => '10.255.255.255' ),
            array('s' => '127.0.0.0'  , 'e' => '127.255.255.255'),
            array('s' => '172.16.0.0' , 'e' => '172.31.255.255' ),
            array('s' => '192.168.0.0', 'e' => '192.168.255.255')
        );
        $isLocalIp = false;
        foreach ( $IPArr as $val ){
            if ( $LongIp >= ip2long($val['s']) &&  $LongIp <= ip2long($val['e']) ) {
                $isLocalIp = true;
                break;
            }
        }
        return $isLocalIp;
    }

    /** 
     * isIdNumber18
     * 判断是否18位身份证号
     * @access public
     * @param  string $IdNum 要判断的身份证号
     * @param  string $Gender 性别 0 女 , 1 男
     * @since  dev
     * @return boolean
     **/
    public static function isIdNumber18 ( $IdNum, $Gender=Null ){
        $Weight = array ( "7","9","10","5","8","4","2","1","6","3","7","9","10","5","8","4","2" );
        $CheckCode = array ( "1","0","X","9","8","7","6","5","4","3","2" );
        $Num = substr ($IdNum, 0, 17);
        $BD = substr ($IdNum, 6 ,8); //生日
        $GC = substr($IdNum, 14, 3); //顺序码
        $CC = substr($IdNum, -1); //校验码
        if ( strlen( $Num ) != 17 || !is_numeric( $Num ) || !in_array( $CC, $CheckCode ) ) { //判断身份证规则
            return false;
        }
        if ( $Gender !== Null && $GC % 2 != $Gender ) { //判断性别
            return false;
        }
        //判断生日
        if ( date('Ymd',strtotime($BD)) != $BD ){
            return false;
        }
        $MaxAge = 130;
        $BY = substr ($BD,0,4);
        $EndYear = date('Y');
        $StartYear = $EndYear - $MaxAge;
        if ( $StartYear > $BY || $BY > $EndYear ) {
            return false;
        }
        //判断校验码
        $CNum = 0;
        for ( $i = 0 ; $i < 17 ; $i ++ ) {
            $CNum += $Num[$i]*$Weight[$i];
        }
        if ( $CheckCode[$CNum % 11] != strtoupper($CC) ) {
            return false;
        }
        return true;
    }

    /** 
     * isIdNumber15
     * 判断是否15位身份证号
     * @access public
     * @param  string $IdNum 要判断的身份证号
     * @param  string $Gender 性别 0 女 , 1 男
     * @since  dev 
     * @return boolean
     **/
    public static function isIdNumber15 ( $IdNum, $Gender=Null ){
        $BD = '19'.substr ($IdNum, 6 ,6); //生日
        $GC = substr($IdNum, 12, 3); //顺序码
        if ( strlen( $IdNum ) != 15 || !is_numeric( $IdNum ) ) { //判断身份证规则
            return false;
        }
        if ( $Gender !== Null && $GC % 2 != $Gender ) { //判断性别
            return false;
        }
        //判断生日
        if ( date('Ymd',strtotime($BD)) != $BD ){
            return false;
        }
        $MaxAge = 130;
        $BY = substr ($BD,0,4);
        $EndYear = date('Y');
        $StartYear = $EndYear - $MaxAge;
        if ( $StartYear > $BY || $BY > $EndYear ) {
            return false;
        }
        return true;
    }
}
