### 日期时间部分

````php
use  \Lit\Utils\LiProgress;
````

#### 1. 使用 pcntl 创建子进程

````php
LiProgress::pcntl([1, 2, 3, 4, 5, 6, 7, 8, 9, 10], 3, function ($value) {
    usleep(rand(1000000, 2000000));
    var_dump("我是 " . $value);
}, false);

//var_dump('结束');
//string(8) "我是 1"
//string(8) "我是 2"
//string(8) "我是 3"
//string(8) "我是 5"
//string(8) "我是 4"
//string(8) "我是 6"
//string(8) "我是 7"
//string(8) "我是 8"
//string(8) "我是 9"
//string(9) "我是 10"
//string(6) "结束"
````