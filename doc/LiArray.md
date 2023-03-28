### 数组部分

````php
use  \Lit\Utils\LiArray;
````

#### 1. 通过正则表达式匹配一维数组的值,返回正则表达式匹配部分

````php
var_dump ( LiArray::regexArray (['aa','bb','cc','ab','ac'],'/^a/') );
//array(3) {
//  [0]=>
//  string(2) "aa"
//  [3]=>
//  string(2) "ab"
//  [4]=>
//  string(2) "ac"
//}
````

#### 2. 递归替换多维数中指定的字符串

````php
var_dump (LiArray::arrayReplace('a','b',['aacd','aag','have','aa'=>['cba']]));
//array(4) {
//  [0]=>
//  string(4) "bbcd"
//  [1]=>
//  string(3) "bbg"
//  [2]=>
//  string(4) "hbve"
//  ["aa"]=>
//  array(1) {
//    [0]=>
//    string(3) "cbb"
//  }
//}
````

#### 3. 标准的XML解析成数组

````php
$xml = '<?xml version="1.0" encoding="UTF-8"?> <note><to>Tove</to><from>Jani</from><heading>Reminder</heading></note>';
var_dump (LiArray::xmlToArray($xml));
//array(3) {
//  ["to"]=>
//  string(4) "Tove"
//  ["from"]=>
//  string(4) "Jani"
//  ["heading"]=>
//  string(8) "Reminder"
//}
````

#### 4. 获取一维数组指定的keys对应的值

````php
var_dump(LiArray::getValues(["a" => 1, "b" => 2, "c" => 3, "d" => 4], ["a", "c"]));
//array(2) {
//  ["a"]=>
//  int(1)
//  ["c"]=>
//  int(3)
//}
````

#### 5. 通过一个数组去排序另外一个数组

````php
$a = ["key" => "key1", "val" => "val2", "good" => "good3",1=>"11",0]; //待排序的数组
$b = ["good", "key",1,"val"]; //想要的顺序
var_dump ( LiArray::sortByArray($a, $b) );
//array(5) {
//  ["good"]=>
//  string(5) "good3"
//  ["key"]=>
//  string(4) "key1"
//  [1]=>
//  string(2) "11"
//  ["val"]=>
//  string(4) "val2"
//  [2]=>
//  int(0)
//}
````

#### 6. 别名一维数组的键名

````php
var_dump(LiArray::keyAlias(["_id" => 1, "_name" => "测试"], ["_id" => "id", "_name" => "name"]));
//array(2) {
//  ["id"]=>
//  int(1)
//  ["name"]=>
//  string(6) "测试"
//}
````

#### 7. 根据二维数组的键名分组

````php
$array = [
    ["name" => "小美", "group_id" => "2"], ["name" => "小帅", "group_id" => "1"],
    ["name" => "阿呆", "group_id" => "2"], ["name" => "阿花", "group_id" => "1"],
    ["name" => "烧饼", "group_name" => "3"],
];
var_dump(LiArray::groupByKey($array, "group_id", "other_group"));
````

#### 8. 从数组中获取一个值,并赋予默认值或删除

````php
$data = ["a" => 1, "b" => 2, "c" => 3];
var_dump(LiArray::get($data, "a")); //获取值
//1
var_dump(LiArray::get($data, "d",0)); //获取不到增加默认值
//0
var_dump($data); //查看数组
var_dump(LiArray::get($data, "b",0,true)); //获取到值后 删除原数据中的数据
var_dump($data);
````

#### 9. 一维数组转二维数组

````php
//一维数组[key=>value,key=>value] 转二维数组 [["keyName"=>"key","valueName"=>"value"]]
$data = [1 => "name1", 2 => "name2", 3 => "name3"];
var_dump(LiArray::kv2td($data, "id", "name"));
//array(3) {
//  [0]=>
//  array(2) {
//    ["id"]=>
//    int(1)
//    ["name"]=>
//    string(5) "name1"
//  } ...
````

#### 10. 查找二维数组中, 指定键匹配指定值的第一个元素

````php
$array = [["a"=>1,"b"=>3],["a"=>2,"b"=>3]];
var_dump ( LiArray::ifValueIs($array,"a",2) );
//array(2) {
//  ["a"]=>
//  int(2)
//  ["b"]=>
//  int(3)
//}
````

#### 11. 数字key下划线转驼峰

````php
var_dump(LiArray::keyToCamelCase(["hello_world" => 123, "docker_hub" => 456]));
//array(2) {
//  ["helloWorld"]=>
//  int(123)
//  ["dockerHub"]=>
//  int(456)
//}

````

#### 12. 数组key驼峰转下划线

````php
var_dump(LiArray::keyToUnderScoreCase(["helloWorld" => 123, "dockerHub" => 456]));
//array(2) {
//  ["hello_world"]=>
//  int(123)
//  ["docker_hub"]=>
//  int(456)
//}
````
