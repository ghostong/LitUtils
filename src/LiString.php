<?php

namespace Lit\Utils;

/**
 * liString: PHP 字符串补充部分
 * @author  litong
 * @since   1.0
 **/
class LiString
{

    /**
     * randStr
     * 获取随机数字符串
     * @access public
     * @param mixed $len 随机字符串长度
     * @param boolean $number 随机字符串是否包含数字
     * @param boolean $letter 随机字符串是否包含小写字母
     * @param boolean $capitals 随机字符串是否包含大写字母
     * @param boolean $symbols 随机字符串是否包含符号
     * @return string
     **@since  1.0
     */
    public static function randStr($len = 8, $number = true, $letter = false, $capitals = false, $symbols = false) {
        $NumArr = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $LetArr = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
        $CapArr = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        $SymArr = ['!', '@', '#', '$', '%', '&', '*', '_', '.'];
        $EndArr = [];
        if ($number) {
            $EndArr = array_merge($EndArr, $NumArr);
        }
        if ($letter) {
            $EndArr = array_merge($EndArr, $LetArr);
        }
        if ($capitals) {
            $EndArr = array_merge($EndArr, $CapArr);
        }
        if ($symbols) {
            $EndArr = array_merge($EndArr, $SymArr);
        }
        $CountNum = count($EndArr) - 1;
        $random = '';
        for ($i = 0; $i < $len; $i++) {
            shuffle($EndArr);
            $random .= $EndArr[mt_rand(0, $CountNum)];
        }
        return $random;
    }

    /**
     * subStrTo
     * 返回 haystack 在首次 needle 出现之前的字符串
     * @access public
     * @param string $haystack 要截取的字符串
     * @param string $needle 首次出现的字符串
     * @return string
     **@since  1.0
     */
    public static function subStrTo($haystack, $needle) {
        if (empty($haystack) || empty($needle)) {
            return $haystack;
        }
        $pos = stripos($haystack, $needle);
        if ($pos !== false) {
            $end = substr($haystack, 0, $pos);
        } else {
            $end = $haystack;
        }
        return $end;
    }


    /**
     * subStr
     * 返回 haystack 在首次 needleStart 与 needleEnd 之间出现之前的字符串
     * @param $haystack
     * @param $needleStart
     * @param $needleEnd
     * @return string
     */
    public static function subStr($haystack, $needleStart, $needleEnd = "") {
        if (empty($haystack) || empty($needleStart)) {
            return $haystack;
        }
        $pos = stripos($haystack, $needleStart);
        if ($pos !== false) {
            $haystack = substr($haystack, $pos + strlen($needleStart));
            if ($needleEnd) {
                return self::subStrTo($haystack, $needleEnd);
            } else {
                return $haystack;
            }
        } else {
            return $haystack;
        }
    }

    /**
     * strEncode
     * 简单字符串可逆加密(加密)
     * @access public
     * @param string $str 要加密的字符串
     * @return string
     **@since  1.0
     */
    public static function strEncode($str) {
        if (strlen($str) == 0) {
            return '';
        }
        $nowArr = [];
        $enStr = base64_encode($str);
        $i = 0;
        while (isset($enStr[$i])) {
            $nowArr[$i] = $enStr[$i];
            if ($i % 2 == 1) {
                $nowArr[$i] = $nowArr[$i - 1];
                $nowArr[$i - 1] = $enStr[$i];
            }
            $i++;
        }
        $NowStr = implode('', $nowArr);
        $HalfLen = floor(strlen($NowStr) / 2);
        $NowStr = substr($NowStr, $HalfLen) . substr($NowStr, 0, $HalfLen);
        $NowStr = str_rot13($NowStr);
        return $NowStr;
    }

    /**
     * strEncode
     * 简单字符串可逆加密(解密)
     * @access public
     * @param string $str 要加密的字符串
     * @return string
     **@since  1.0
     */
    public static function strDecode($str) {
        if (strlen($str) == 0) {
            return '';
        }
        $nowStr = str_rot13($str);
        $halfLen = ceil(strlen($nowStr) / 2);
        $nowStr = substr($nowStr, $halfLen) . substr($nowStr, 0, $halfLen);
        $i = 0;
        $nowArr = [];
        while (isset($nowStr[$i])) {
            $nowArr[$i] = $nowStr[$i];
            if ($i % 2 == 1) {
                $nowArr[$i] = $nowArr[$i - 1];
                $nowArr[$i - 1] = $nowStr[$i];
            }
            $i++;
        }
        $EnStr = implode('', $nowArr);
        $str = base64_decode($EnStr);
        return $str;
    }

    /**
     * strLimit
     * 限制字符串的字符数量
     * @access public
     * @param string $value 原字符串
     * @param int $limit 限制字符长度
     * @param string $end 结尾连接符
     * @return string
     **@since  1.0
     */
    public static function strLimit($value, $limit = 100, $end = '...') {
        if (mb_strwidth($value, 'UTF-8') <= $limit) {
            return $value;
        }
        return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')) . $end;
    }

    /**
     * replaceStringVariable
     * 替换字符串中的变量占位符
     * @access public
     * @param string $string 要替换的字符串
     * @param array $varArr 变量数组
     * @return string
     * @since  1.0
     * @example
     *     $string = '我是要替换的字符串,我的名字叫{$name},{$other}快来帮助我!!';  //此处应该为从文件读取的内容
     *     $varArr = ["name"=>"litool","other"=>"haha"];
     *     self::replaceStringVariable($string,$varArr);
     **/
    public static function replaceStringVariable($string, $varArr) {
        $search = [];
        $replace = [];
        foreach ($varArr as $key => $val) {
            $search[] = '{$' . $key . '}';
            $replace[] = $val;
        }
        return str_replace($search, $replace, $string);
    }

    /**
     * toUnderScoreCase
     * 下划线转驼峰
     * @access public
     * @param string $str hello_my_name_is8a_h5_array
     * @return string
     * @since  1.0
     */
    public static function toCamelCase($str) {
        return preg_replace_callback('/_+([0-9,a-z])/', function ($matches) {
            return strtoupper($matches[1]);
        }, $str);
    }

    /**
     * toUnderScoreCase
     * 驼峰转下划线
     * @access public
     * @param string $str HelloMyNameIs8aH5Array
     * @return string
     * @since  1.0
     */
    public static function toUnderScoreCase($str) {
        return strtolower(preg_replace('/(?<=[a-z])([A-Z])/', '_$1', $str));
    }

}