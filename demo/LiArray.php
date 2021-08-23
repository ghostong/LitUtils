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

//通过一个数组去排序另外一个数组
$a = ["key" => "key1", "val" => "val2", "good" => "good3", 1 => "11", 0]; //待排序的数组
$b = ["good", "key", 1, "val"]; //想要的顺序
var_dump(LiArray::sortByArray($a, $b));

//别名一维数组的键名
var_dump(LiArray::keyAlias(["_id" => 1, "_name" => "测试"], ["_id" => "id", "_name" => "name"]));

//根据二维数组的键名分组
$array = [
    ["name" => "小美", "group_id" => "2"],
    ["name" => "小帅", "group_id" => "1"],
    ["name" => "阿呆", "group_id" => "2"],
    ["name" => "阿花", "group_id" => "1"],
    ["name" => "烧饼", "group_name" => "3"],
];
var_dump(LiArray::groupByKey($array, "group_id", "other_group"));