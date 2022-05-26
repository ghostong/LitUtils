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
     * sortByArray
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

    /**
     * 别名一维数组的键名
     * @date 2021/8/23
     * @param array $array 原始数组
     * @param array $alias 别名数组
     * @return array
     * @author litong
     */
    public static function keyAlias($array, $alias) {
        foreach ($alias as $key => $value) {
            if (isset($array[$key])) {
                $array[$value] = $array[$key];
                unset($array[$key]);
            }
        }
        return $array;
    }

    /**
     * 根据二维数组的键名分组
     * @date 2021/8/23
     * @param array $array 要分组的数据
     * @param string $key 二维数组的key
     * @param string $notExistsAlias 二维数组的key
     * @return array
     * @author litong
     */
    public static function groupByKey($array, $key, $notExistsAlias = "") {
        $return = [];
        foreach ($array as $value) {
            $return[isset($value[$key]) ? $value[$key] : $notExistsAlias][] = $value;
        }
        return $return;
    }

    /**
     * 从数组中获取一个值,并赋予默认值或删除
     * @date 2021/12/13
     * @param array $array 原始数组
     * @param mixed $key 要获取的数组key
     * @param null $default 未获取到时的默认值
     * @param bool $unset 获取后是否删除
     * @return mixed|null
     * @author litong
     */
    public static function get(&$array, $key, $default = null, $unset = false) {
        $return = isset($array[$key]) ? $array[$key] : $default;
        if (true === $unset) {
            unset($array[$key]);
        }
        return $return;
    }

    /**
     * 一维数组[key=>value,key=>value] 转二维数组 [["keyName"=>"key","valueName"=>"value"]]
     * @date 2022/3/23
     * @param array $array 一维数组
     * @param int $keyName 二维数组 第一个value名称
     * @param int $valueName 二维数组 第二个value名称
     * @return array|array[]
     * @author litong
     */
    public static function kv2td($array, $keyName = 0, $valueName = 1) {
        return array_map(function ($value, $key) use ($keyName, $valueName) {
            return [$keyName => $key, $valueName => $value];
        }, $array, array_keys($array));
    }

    /**
     * 查找二维数组中, 指定键匹配指定值的第一个元素
     * @date 2022/5/26
     * @param array $array 被查找的数组
     * @param mixed $key 被查找二维数组的Key
     * @param mixed $search 被查找的值
     * @return mixed|null
     * @author litong
     */
    public static function ifValueIs($array, $key, $search) {
        foreach ($array as $value) {
            if (isset($value[$key]) && $value[$key] == $search) {
                return $value;
            }
        }
        return null;
    }
}
