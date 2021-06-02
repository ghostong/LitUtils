<?php

require(dirname(__DIR__) . '/vendor/autoload.php');

################################

use  \Lit\Utils\LiArray;

//通过正则表达式匹配一维数组的值,返回正则表达式匹配部分
var_dump(LiArray::regexArray(['aa', 'bb', 'cc', 'ab', 'ac'], '/^a/'));

//归替换多维数中指定的字符串
var_dump(LiArray::arrayReplace('a', 'b', ['aacd', 'aag', 'have', 'aa' => ['cba']]));

//标准的XML解析成数组
$xml = '<?xml version="1.0" encoding="UTF-8"?> <note><to>Tove</to><from>Jani</from><heading>Reminder</heading></note>';
var_dump(LiArray::xmlToArray($xml));

//获取一维数组指定的keys对应的值
var_dump(LiArray::getValues(["a" => 1, "b" => 2, "c" => 3, "d" => 4], ["a", "c"]));
