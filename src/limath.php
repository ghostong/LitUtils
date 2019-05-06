<?php 

namespace lit\litool;

/**
 * limath: litool PHP 数学计算部分
 * @author  litong
 * @since   1.0
 **/

class limath {
    
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
     * Base10to62
     * 10进制转62进制
     * @access public
     * @param  int  $n  要转换为62进制的10进制数字
     * @since  1.0 
     * @return string
     **/
    public static function Base10to62( $n ){
        $base = 62;  
        $index = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';  
        $ret = '';  
        for($t = floor(log10($n) / log10($base)); $t >= 0; $t --) {  
            $a = floor($n / pow($base, $t));  
            $ret .= substr($index, $a, 1);  
            $n -= $a * pow($base, $t);  
        }  
        return $ret ? $ret : 0;  

    }

    /** 
     * Base62to10
     * 62进制转10进制
     * @access public
     * @param  string  $s  要转换为10进制的62进制字符串
     * @since  1.0 
     * @return int
     **/
    public static function Base62to10( $s ){
        $base = 62;  
        $index = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';  
        $ret = 0;  
        $len = strlen($s) - 1;  
        for($t = 0; $t <= $len; $t ++) {  
            $ret += strpos($index, substr($s, $t, 1)) * pow($base, $len - $t);  
        }  
        return $ret; 
    }

    /**
     * Between
     * num是否在start,end中间(包含边界)
     * @access public
     * @param  int  $num    要对比度数字
     * @param  int  $start  开始数字(含)
     * @param  int  $end    结束数字(含)
     * @since  1.0
     * @return bool
     **/
    public static function Between ( $num, $start, $end ){
        if ( $start <= $num && $num <= $end){
            return true;
        }else{
            return false;
        }
    }

}
