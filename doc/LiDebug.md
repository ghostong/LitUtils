### 数组部分

````php
use  \Lit\Utils\LiDebug;
````

#### 1. 增加调试埋点

````php
LiDebug::anchor("xxx");
````

#### 2. 获取调试日志

````php
var_dump(LiDebug::getAll());
//array(3) {
//  [0]=>
//  array(4) {
//    ["file"]=>
//    string(48) "../demo/LiDebug.php"
//    ["line"]=>
//    int(14)
//    ["time"]=>
//    string(15) "1686552336.2963"
//    ["log"]=>
//    string(3) "xxx"
//  }
//  ...
//  ...
//}
````

#### 3. 获取格式化的调试日志

````php
var_dump(LiDebug::getFormat());
//array(3) {
//  [0]=>
//  string(73) "[1686552336.2963] .../demo/LiDebug.php:14 xxx"
//  [1]=>
//  string(73) "[1686552336.2964] .../demo/LiDebug.php:10 aaa"
//  [2]=>
//  string(73) "[1686552336.2964] .../demo/LiDebug.php:16 xxx"
//}
````