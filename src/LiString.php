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

    /**
     * 汉字转阿拉伯数字
     * @param string $string 九千零三亿一千零二十七万零二佰五十
     * @return int|null 900310270250 | null
     */
    public static function str2num($string) {
        $d = array(
            "一" => 1, "二" => 2, "三" => 3, "四" => 4, "五" => 5, "六" => 6, "七" => 7, "八" => 8, "九" => 9,
            "壹" => 1, "贰" => 2, "叁" => 3, "肆" => 4, "伍" => 5, "陆" => 6, "柒" => 7, "捌" => 8, "玖" => 9,
            '零' => 0, '0' => 0, 'O' => 0, 'o' => 0,
            '两' => 2
        );

        if (isset($d[$string])) {
            return intval($d[$string]);
        }

        $replace = ["仟" => "千", "佰" => "百", "拾" => "十", "万万" => "亿",];
        $string = str_replace(array_keys($replace), $replace, $string);

        $num = 0;
        $delimiters = [
            '兆' => 1000 * 1000 * 1000 * 1000,
            '亿' => 100 * 1000 * 1000,
            '万' => 10 * 1000,
            '千' => 1000,
            '百' => 100,
            '十' => 10,
            '零' => 0
        ];

        foreach ($delimiters as $delimiter => $value) {
            $unit = explode($delimiter, $string);
            if (count($unit) > 1) {
                $num += self::str2num($unit[0] ? $unit[0] : '一') * $value;
                $string = $unit[1] ? $unit[1] : '零';
            }
        }

        if (isset($d[$string])) {
            return intval($num + $d[$string]);
        } else {
            return empty($string) ? $num : null;
        }
    }

    /**
     * 一维数组转原生SQL
     * @date 2021/6/18
     * @param array $array 要生成SQL的数组
     * @param string $table 表名
     * @param string $database 库名
     * @return string
     * @author litong
     */
    public static function array2sql($array, $table, $database = null) {
        $dt = ($database === null) ? $table : ($database . "`.`" . $table);
        $keys = array_keys($array);
        $values = array_map(function ($value) {
            return addslashes($value);
        }, $array);
        return sprintf('insert into `%s` ( `%s` ) values ( "%s" )', $dt, implode('`, `', $keys), implode('", "', $values));
    }

    /**
     * 构建 insert sql: on duplicate key update 后半部分字符串
     * @date 2021/9/17
     * @param array $fields 要更新部分字段
     * @param array $excludeFields 要排除更新部分字段
     * @return string
     * @author litong
     */
    public static function array2DuplicateKeySql($fields, $excludeFields) {
        $fields = array_diff($fields, $excludeFields);
        $result = "";
        foreach ($fields as $field) {
            $result .= sprintf("%s=VALUES(%s),", $field, $field);
        }
        return trim($result, ",");
    }

    /**
     * 从字符串中提取id
     * @date 2021/7/15
     * @param $string
     * @return array
     * @author litong
     */
    public static function getIdsByStr($string) {
        preg_match_all('/[0-9]+/', $string, $matches);
        return current($matches);
    }

    /**
     * 判断 UTF-8 字符是否包含乱码
     * @date 2021/7/26
     * @param $string
     * @return bool
     * @author litong
     */
    public static function hasMessyCodes($string) {
        if (json_encode($string) === false) {
            return true;
        }
        if (mb_convert_encoding($string, "UTF-8", "UTF-8") !== $string) {
            return true;
        }
        return false;
    }

    /**
     * GB18030(GBK|GB2312) 转 UTF-8
     * @date 2021/7/26
     * @param $string
     * @return string
     * @author litong
     */
    public static function gb2u($string) {
        return mb_convert_encoding($string, "UTF-8", "GB18030");
    }

    /**
     * UTF-8 转 GB18030(GBK|GB2312)
     * @date 2021/7/26
     * @param $string
     * @return string
     * @author litong
     */
    public static function u2gb($string) {
        return mb_convert_encoding($string, "GB18030", "UTF-8");
    }

    /**
     * 一维数组转成CSV单行字符串
     * @date 2022/1/19
     * @param string[] $array
     * @return string
     * @author litong
     */
    public static function toCsvString($array) {
        $array = array_map(function ($value) {
            $value = str_replace(["\r\n", "\n\r", "\r", "\n"], "\n", $value);
            $value = str_replace('"', '""', $value);
            return '"' . $value . '"';
        }, $array);
        return implode(",", $array);
    }

    /**
     * 生成uuid v4
     * @date 2023/4/24
     * @return string
     * @author litong
     */
    public static function uuidV4() {
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * 是否 MySQL 唯一键冲突错误
     * @date 2023/7/18
     * @param $message
     * @return bool
     * @author litong
     */
    public static function isSqlDuplicateEntryMsg($message) {
        if (false !== stripos($message, "Duplicate entry") && false !== stripos($message, "for key")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 是否md5字符串
     * @date 2023/7/28
     * @param $string
     * @return bool
     * @author litong
     */
    public static function isMd5String($string) {
        if (preg_match('/^[a-f0-9]{32}$/', $string)) {
            return true;
        } else {
            return false;
        }
    }
}
