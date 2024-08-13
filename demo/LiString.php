<?php

require(dirname(__DIR__) . '/vendor/autoload.php');


################################

use  \Lit\Utils\LiString;

//去除字符串首尾处的指定字符串
var_dump(LiString::trim("好吧,你说你的心里到底装的什么?", ['好吧,', '的什么?']));

//使用数组分割字符串
var_dump(LiString::explodeByArray([',', '.', '_ '], "what,is.you_ name"));

//是否md5字符串
var_dump(LiString::isMd5String('01234567890123456789012345678901'));

//判断是否 MySQL 唯一键冲突错误
var_dump(LiString::isSqlDuplicateEntryMsg("Duplicate entry '513-1-3-1.1.1.1' for key 'unique_key'"));

//生成uuid v4
var_dump(LiString::uuidV4());

//从字符串中提取ID
var_dump(LiString::getIdsByStr("123\n9900,1231,4333分割889"));

//汉字转阿拉伯数字
var_dump(LiString::str2num('九千零五百一十三兆九千零三亿一千零二十七万零二佰五十'));

//获取随机数字符串
var_dump(LiString::randStr(8, true, true, true, true));

//返回 haystack 在首次 needle 出现之前的字符串
var_dump(LiString::subStrTo('i can say my abc !', ' my'));

//简单字符串可逆加密(加密)
$Encode = LiString::strEncode('可逆运算');
var_dump($Encode);

//简单字符串可逆加密(解密)
$Decode = LiString::strDecode($Encode);
var_dump($Decode);

//限制字符串的字符数量
var_dump(LiString::strLimit('不a管b什么样的字符都可以了', 7));

//替换字符串中的变量占位符
var_dump(LiString::replaceStringVariable('我叫{$name}', array('name' => 'litool')));

//下划线字符串转驼峰字符串
var_dump(LiString::toCamelCase("hello_my_name_is8a_h5_array"));

//驼峰字符串转下划线字符串
var_dump(LiString::toUnderScoreCase("HelloMyNameIs8aH5Array"));

//一维数组转原生 insert SQL
var_dump(LiString::array2sql(["name" => "test", "id" => 12], "table1", "database"));

//构建 insert sql: on duplicate key 后半部分字符串
var_dump(LiString::array2DuplicateKeySql(["field1", "field2", "field3", "field4"], ["field3", "field5"]));

//判断UTF-8字符串是否含有乱码
var_dump(LiString::hasMessyCodes("是否含有乱码"));

//GB18030 字符集转 UTF-8 字符集
var_dump(LiString::gb2u("GB18030 Code"));

//UTF-8 字符集转 GB18030 字符集
var_dump(LiString::u2gb("GB18030 Code"));

//一维数组转成CSV单行字符串
$array = ["name" => "小狮子", "id" => 1122, "address" => "China Xi'an \n \r \"Chang an\""];
echo LiString::toCsvString($array);

//url 拼接参数
$url = 'https://www.baidu.com:112?a=1&b=2';
var_dump ( LiString::urlAppendParams($url, ['aa' => 1, 'ba' => 2]) );