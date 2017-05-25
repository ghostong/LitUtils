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

    /** 
     * SendHttpStatus
     * 发送http状态码
     * @access public
     * @param  intval $code  Http状态码
     * @since  1.0 
     * @return mixed
     **/
    public static function SendHttpStatus($code) {
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
     * GetWeight
     * 根据权重随机返回被选数据
     * @access public
     * @param  intval $code  Http状态码
     * @since  1.0 
     * @return mixed
     **/
    public static function GetWeight( $wd ){
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
     * IsLocalIp
     * 判断是否私网IP
     * @access public
     * @param  string $IP  要判官的IP
     * @since  1.0 
     * @return mixed
     **/
    public static function IsLocalIp($IP){
        $LongIp = ip2long($IP);
        $IPArr = array(
            array('s' => '10.0.0.0'   , 'e' => '10.255.255.255' ),
            array('s' => '127.0.0.0'  , 'e' => '127.255.255.255'),
            array('s' => '172.16.0.0' , 'e' => '172.31.255.255' ),
            array('s' => '192.168.0.0', 'e' => '192.168.255.255')
        );
        $IsLocalIp = false;
        foreach ( $IPArr as $val ){
            if ( $LongIp >= ip2long($val['s']) &&  $LongIp <= ip2long($val['e']) ) {
                $IsLocalIp = true;
                break;
            }
        }
        return $IsLocalIp;
    }

}
