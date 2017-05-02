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
     * @return array
     **/
    public static function RandStr ( $len=8, $number=true, $letter=false, $capitals=false , $symbols=false ) {
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

}
