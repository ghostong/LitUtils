<?php

use Lit\Utils\LiFileOperator;

require(dirname(__DIR__) . '/vendor/autoload.php');

//递归(选填)列出目录中所有的文件
var_dump(LiFileOperator::listFiles(dirname(__DIR__), true));

//递归(选填)列出目录中所有的目录
var_dump(LiFileOperator::listDirs(dirname(__DIR__), true));