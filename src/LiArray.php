<?php

namespace Lit\Utils;

/**
 * liArray: PHP 数组补充部分
 * @author  litong
 * @since   1.0
 **/
class LiArray
{
    /**
     * regexArray
     * 通过正则表达式匹配一维数组的值,返回正则表达式匹配部分
     * @access public
     * @param array $array 要匹配的数组
     * @param string $regex 要执行的这则表达式
     * @return array
     * @since  1.0
     */
    public static function regexArray($array = array(), $regex = '') {
        if (empty($array) || !is_array($array) || empty($regex)) {
            return $array;
        }
        $ArrIter = new \ArrayIterator($array);
        $iterator = new \RegexIterator($ArrIter, $regex);
        return iterator_to_array($iterator);
    }

    /**
     * arrayReplace
     * 递归替换多维数中指定的字符串
     * @access public
     * @param string $search 搜索被替换的字符串
     * @param string $replace 替换成的字符串
     * @param array $array 被替换的数组
     * @return array
     * @since  1.0
     */
    public static function arrayReplace($search, $replace, $array) {
        if (empty($search) || empty($replace) || empty($array)) {
            return $array;
        }
        if (is_array($array)) {
            foreach ($array as $key => &$val) {
                $array[$key] = self::arrayReplace($search, $replace, $val);
            }
            return $array;
        } else {
            return str_replace($search, $replace, $array);
        }
    }

    /**
     * xmlToArray
     * 标准的XML解析成数组
     * @access public
     * @param string $xml 要转换的XML字符串
     * @return array
     * @since  1.0
     */
    public static function xmlToArray($xml) {
        libxml_disable_entity_loader(true);
        $xmlString = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        return json_decode(json_encode($xmlString), true);
    }

    /**
     * getValues
     * 获取一维数组指定的keys对应的值
     * @access public
     * @param array $array 待获取的数组
     * @param array $keys 要提取的数组key
     * @return array
     * @since  1.0
     */
    public static function getValues($array, $keys) {
        return array_intersect_key($array, array_fill_keys($keys, null));
    }

    /**
     * 通过一个数组去排序另外一个数组
     * @date 2021/6/8
     * @param array $array 要排序的数组
     * @param array $sortArray 想要的顺序数组key
     * @return array
     * @author litong
     */
    public static function sortByArray($array, $sortArray) {
        $newArray = [];
        foreach ($sortArray as $value) {
            if (isset($array[$value])) {
                $newArray[$value] = $array[$value];
                unset($array[$value]);
            }
        }
        return $newArray + $array;
    }

}
