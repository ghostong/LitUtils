<?php

require(dirname(__DIR__) . '/vendor/autoload.php');

################################

//进程内数据缓存, 用于全局数据传输, 避免污染 $GLOBALS

use  \Lit\Utils\LiTransit;

//写入一条缓存
var_dump(LiTransit::set("a", 2));

//不存在时写入一条缓存
var_dump(LiTransit::setNX("a", 4));

//获取一条缓存
var_dump(LiTransit::get("a"));

//判断缓存是否存在
var_dump(LiTransit::exists("c"));

//删除缓存数据
var_dump(LiTransit::rm("b"));

//获取所有缓存护具
var_dump(LiTransit::getAll());



