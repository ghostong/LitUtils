<?php

use Lit\Utils\LiFileListen;

require(dirname(__DIR__) . '/vendor/autoload.php');

################################

//监听文件 __DIR__ . "/test.txt" 并把新增行传给 回调函数的参数 $line
$fileListen = new LiFileListen([
    __DIR__ . "/test.txt" => function ($line) {
        var_dump($line);
    }
]);
$fileListen->run();
