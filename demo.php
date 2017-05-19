<?php

require(__DIR__.'/vendor/autoload.php');

#初始化调用 可以确定依赖是否完善,只调用一次即可
use lit\litool\liinit;

liinit::init();
echo "\n";

################################

use  \lit\litool\liarray;

#通过正则表达式匹配一维数组的值,返回正则表达式匹配部分
var_dump ( liarray::RegexArray (['aa','bb','cc','ab','ac'],'/^a/') );

#归替换多维数中指定的字符串
var_dump (liarray::ArrayReplace('a','b',['aacd','aag','have','aa'=>['cba']]));

################################

use  \lit\litool\listring;

#获取随机数字符串
var_dump ( listring::RandStr(8,true,true,true,true) );

#返回 haystack 在首次 needle 出现之前的字符串
var_dump ( listring::SubStrTo('i can say my abc !',' my') );

#简单字符串可逆加密(加密)
$Encode = listring::StrEncode('可逆运算');
var_dump ( $Encode );

#简单字符串可逆加密(解密)
$Decode = listring::StrDecode($Encode);
var_dump ( $Decode );

################################

use  \lit\litool\lidate;

#返回当前时间以秒为单位的微秒数
var_dump ( lidate::MicroTime() );

#回当前时间以秒为单位的毫秒数
var_dump ( lidate::MilliTime() );

#返回中文格式化的时间
var_dump ( lidate::DateFormat('1494475359') );


