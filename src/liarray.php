<?php 

namespace lit\litool;

/**
 * liarray: litool PHP 数组部分
 * @author  litong
 * @since   1.0
 **/

class liarray {

    /** 
     * init
     * 测试调用
     * @access public static
     * @since  1.0 
     * @return string
     **/
    public static function init (){
        return __CLASS__.'::'.__FUNCTION__;
    }

    /** 
     * RegexArray
     * 通过正则表达式匹配一维数组的值,返回正则表达式匹配部分
     * @access public static
     * @param  array  $array 要匹配的数组
     * @param  string $regex 要执行的这则表达式
     * @since  1.0 
     * @return array
     **/
    public static function RegexArray ($array=array(),$regex='') {
        if ( empty($array) || !is_array ($array) || empty($regex) ) {
            return $array;
        }
        $ArrIter = new \ArrayIterator($array);
        $iterator = new \RegexIterator($ArrIter,$regex);
        return iterator_to_array($iterator);
    }


}
