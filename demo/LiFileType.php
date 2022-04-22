<?php

require(dirname(__DIR__) . '/vendor/autoload.php');

################################

use  \Lit\Utils\LiFileType;

//判断文件是否文件
var_dump(LiFileType::isFile("./a.jpg"));

//判断文件是否图片
var_dump(LiFileType::isImage("./a.jpg"));

//判断文件是否视频
var_dump(LiFileType::isVideo("./a.mp4"));

//判断文件是否音频
var_dump(LiFileType::isAudio("./a.mp3"));

//判断文件是否文本
var_dump(LiFileType::isText("./a.php"));