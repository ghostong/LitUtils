### 字符串部分

````php
use  \Lit\Utils\LiString;
````

#### 1. 汉字转阿拉伯数字

````php
var_dump( LiString::str2num('九千五百一十三兆九千零三亿一千零二十七万零二佰五十') );
//int(9513900310270250)
````

#### 2. 获取随机数字符串

````php
var_dump ( LiString::randStr(8,true,true,true,true) );
//string(8) "to6HG!w6"
````

#### 3. 返回 haystack 在首次 needle 出现之前的字符串

````php
var_dump ( LiString::subStrTo('i can say my abc !',' my') );
//string(9) "i can say"
````

#### 4. 简单字符串可逆加密(加密)

````php
var_dump ( LiString::strEncode('可逆运算') );
//string(16) "Y6D+65K6L5i+L6TP"
````

#### 5. 简单字符串可逆加密(解密)

````php
var_dump ( LiString::strDecode("Y6D+65K6L5i+L6TP") );
//string(12) "可逆运算"
````

#### 6. 限制字符串的字符数量

````php
var_dump(LiString::strLimit('不a管b什么样的字符都可以了', 7));
//string(11) "不a管b..."
````

#### 7. 替换字符串中的变量占位符

````php
var_dump(LiString::replaceStringVariable('我叫{$name}', array('name' => 'litool')));
//string(12) "我叫litool"
````

#### 8. 下划线字符串转驼峰字符串

````php
var_dump(LiString::toCamelCase("hello_my_name_is8a_h5_array"));
//string(22) "helloMyNameIs8aH5Array"
````

#### 9. 驼峰字符串转下划线字符串

````php
var_dump(LiString::toUnderScoreCase("HelloMyNameIs8aH5Array"));
//string(26) "hello_my_name_is8a_h5array"
````

#### 10. 一维数组转原生insert SQL

````php
var_dump(LiString::array2sql(["name" => "test", "id" => 12],"table1", "database"));
//string(71) "insert into `database`.`table1` ( `name`, `id` ) values ( "test", "12" )"
````

#### 11. 构建 insert sql: on duplicate key 后半部分字符串

````php
//构建 insert sql: on duplicate key 后半部分字符串
var_dump(LiString::array2DuplicateKeySql(["field1", "field2", "field3", "field4"], ["field3", "field5"]));
//string(65) "field1=VALUES(field1),field2=VALUES(field2),field4=VALUES(field4)"
````

#### 12. 从字符串中提取ID

````php
var_dump(LiString::getIdsByStr("123\n9900,1231,4333分割889"));
//array(5) {
//  [0]=>
//  string(3) "123"
//  [1]=>
//  string(4) "9900"
//  [2]=>
//  string(4) "1231"
//  [3]=>
//  string(4) "4333"
//  [4]=>
//  string(3) "889"
//}
````

#### 13. 判断UTF-8字符串是否含有乱码

````php
var_dump(LiString::hasMessyCodes("是否含有乱码"));
//bool(false)
````

#### 14. GB18030 字符集转 UTF-8 字符集

````php
var_dump(LiString::gb2u("GB18030 Code"));
//string(10) "UTF-8 Code"
````

#### 15. UTF-8 字符集转 GB18030 字符集

````php
var_dump(LiString::u2gb("UTF-8 Code"));
//string(12) "GB18030 Code"
````

#### 16. 一维数组转成CSV单行字符串

````php
$array = ["name"=>"小狮子","id"=>1122,"address"=>"China Xi'an \n \r \"Chang an\""];
echo LiString::toCsvString($array);
//"小狮子","1122","China Xi'an 
// 
// ""Chang an"""
````