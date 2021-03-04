<?php

require(dirname(__DIR__) . '/vendor/autoload.php');


################################

use  \Lit\Utils\LiString;

#获取随机数字符串
var_dump(LiString::randStr(8, true, true, true, true));

#返回 haystack 在首次 needle 出现之前的字符串
var_dump(LiString::subStrTo('i can say my abc !', ' my'));

#简单字符串可逆加密(加密)
$Encode = LiString::strEncode('可逆运算');
var_dump($Encode);

#简单字符串可逆加密(解密)
$Decode = LiString::strDecode($Encode);
var_dump($Decode);

#限制字符串的字符数量
var_dump(LiString::strLimit('不a管b什么样的字符都可以了', 7));

#替换字符串中的变量占位符
var_dump(LiString::replaceStringVariable('我叫{$name}', array('name' => 'litool')));

#下划线字符串转驼峰字符串
var_dump(LiString::toCamelCase("hello_my_name_is8a_h5_array"));

#驼峰字符串转下划线字符串
var_dump(LiString::toUnderScoreCase("HelloMyNameIs8aH5Array"));

