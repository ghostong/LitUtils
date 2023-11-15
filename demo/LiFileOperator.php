<?php

use Lit\Utils\LiFileOperator;

require(dirname(__DIR__) . '/vendor/autoload.php');


//递归(选填)列出目录中所有的文件
var_dump(LiFileOperator::listFiles(dirname(__DIR__), false));

//递归(选填)列出目录中所有的目录
var_dump(LiFileOperator::listDirs(dirname(__DIR__), true));

//目录结构转为数组结构
var_dump(LiFileOperator::dirToArray(dirname(__DIR__)));

//获取一个临时文件名
var_dump(LiFileOperator::getTmpFileName());

//文件写入临时文件
var_dump(LiFileOperator::writeToTmpFile(111222));