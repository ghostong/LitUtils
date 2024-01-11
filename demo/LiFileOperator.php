<?php

use Lit\Utils\LiFileOperator;

require(dirname(__DIR__) . '/vendor/autoload.php');


//列出文件的时间并作用到回调函数
LiFileOperator::listFilesByTime(dirname(__DIR__), LiFileOperator::CTIME, function ($fileTime, $realpath) {
    var_dump($fileTime, $realpath);
});

//列出文件的时间
$listFiles = LiFileOperator::listFilesByTime(dirname(__DIR__), LiFileOperator::CTIME);
var_dump($listFiles);


//递归(选填)列出目录中所有的文件
$listFiles = LiFileOperator::listFiles(dirname(__DIR__), false);
foreach ($listFiles as $file) {
    var_dump($file);
}


//递归(选填)列出目录中所有的目录
$listFiles = LiFileOperator::listDirs(dirname(__DIR__), true);
foreach ($listFiles as $file) {
    var_dump($file);
}


//目录结构转为数组结构
var_dump(LiFileOperator::dirToArray(dirname(__DIR__)));

//获取一个临时文件名
var_dump(LiFileOperator::getTmpFileName());

//文件写入临时文件
var_dump(LiFileOperator::writeToTmpFile(111222));