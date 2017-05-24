<?php 

namespace lit\litool;

/**
 * listring: litool PHP 字符串部分
 * @author  litong
 * @since   1.0
 **/

class listring {
    
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
     * RandStr
     * 获取随机数字符串
     * @access public
     * @param  mixed   $len      随机字符串长度
     * @param  boolean $number   随机字符串是否包含数字
     * @param  boolean $letter   随机字符串是否包含小写字母
     * @param  boolean $capitals 随机字符串是否包含大写字母
     * @param  boolean $symbols  随机字符串是否包含符号
     * @since  1.0 
     * @return string
     **/
    public static function RandStr ( $len=8, $number=true, $letter=false, $capitals=false , $symbols=false ){
        $NumArr = array ('0','1','2','3','4','5','6','7','8','9');
        $LetArr = array ('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
        $CapArr = array ('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $SymArr = array ('!','@','#','$','%','&','*','_','.');
        $EndArr = array ();
        if ($number) {
            $EndArr = array_merge ($EndArr,$NumArr);
        }
        if ($letter) {
            $EndArr = array_merge ($EndArr,$LetArr);
        }
        if ($capitals) {
            $EndArr = array_merge ($EndArr,$CapArr);
        }
        if ($symbols) {
            $EndArr = array_merge ($EndArr,$SymArr);
        }
        $CountNum = count($EndArr) - 1;
        $random = '';
        for ($i = 0 ; $i < $len ; $i ++ ) {
            shuffle ($EndArr);
            $random .= $EndArr[mt_rand(0,$CountNum)];
        }
        return $random;
    }

    /** 
     * SubStrTo
     * 返回 haystack 在首次 needle 出现之前的字符串
     * @access public
     * @param  string  $haystack  要截取的字符串
     * @param  string  $needle    首次出现的字符串
     * @since  1.0 
     * @return string
     **/
    public static function SubStrTo( $haystack, $needle ){
        if ( empty($haystack) || empty($needle) ) {
            return $haystack;
        }
        $pos = stripos ( $haystack, $needle );
        if ( $pos !== false ) {
            $end = substr( $haystack, 0, $pos );
        }else{
            $end = $haystack;
        }
        return $end;
    }


    /** 
     * StrEncode
     * 简单字符串可逆加密(加密)
     * @access public
     * @param  string  $Str 要加密的字符串
     * @since  1.0 
     * @return string
     **/
    public static function StrEncode($Str){
        if ( strlen($Str) == 0 ){ return ''; }
        $NowArr = array();
        $EnStr=base64_encode($Str);
        $i = 0;
        while(isset($EnStr[$i])) {
            $NowArr[$i] = $EnStr[$i];
            if ($i%2 == 1) { $NowArr[$i] = $NowArr[$i-1];$NowArr[$i-1] = $EnStr[$i];}
            $i++;
        }
        $NowStr = implode('',$NowArr);
        $HalfLen = floor(strlen($NowStr) / 2);
        $NowStr = substr ($NowStr,$HalfLen).substr ($NowStr,0,$HalfLen);
        $NowStr = str_rot13($NowStr);
        return $NowStr;
    }
    
    /** 
     * StrEncode
     * 简单字符串可逆加密(解密)
     * @access public
     * @param  string  $Str 要加密的字符串
     * @since  1.0 
     * @return string
     **/
    public static function StrDecode($Str){
        if ( strlen($Str) == 0 ){ return ''; }
        $NowStr = str_rot13($Str);
        $HalfLen = ceil(strlen($NowStr) / 2);
        $NowStr = substr ($NowStr,$HalfLen).substr ($NowStr,0,$HalfLen);
        $i=0;
        while(isset($NowStr[$i])) {
            $NowArr[$i] = $NowStr[$i];
            if ($i%2 == 1) { $NowArr[$i] = $NowArr[$i-1]; $NowArr[$i-1] = $NowStr[$i];}
            $i++;
        }
        $EnStr = implode('',$NowArr);
        $Str = base64_decode($EnStr);
        return $Str;
    }

    /** 
     * StrLimit
     * 限制字符串的字符数量
     * @access public
     * @param  string  $value  原字符串
     * @param  intval  $limit  限制字符长度
     * @param  string  $end  结尾连接符
     * @since  1.0 
     * @return string
     **/
    public static function StrLimit($value, $limit = 100, $end = '...') {
        if (mb_strwidth($value, 'UTF-8') <= $limit) {
            return $value;
        }
        return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')).$end;
    }

}
