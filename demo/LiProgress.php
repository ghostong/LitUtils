<?php

use Lit\Utils\LiProgress;

require(dirname(__DIR__) . '/vendor/autoload.php');

################################

//使用 pcntl 创建子进程
LiProgress::pcntl([1, 2, 3, 4, 5, 6, 7, 8, 9, 10], 3, function ($value) {
    usleep(rand(1000000, 2000000));
    var_dump("我是 " . $value);
}, false);

var_dump('结束');