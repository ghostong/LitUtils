<?php

require(dirname(__DIR__) . '/vendor/autoload.php');

################################

//单例获取 LiEasyAuth 对象
//注意: 此系统只适用于简单身份认证,不适合高并发,大数据量,高安全性的用户系统
$easyAuth = \Lit\Utils\LiEasyAuth::getInstance("/tmp/aaa");

//创建一个用户
var_dump($easyAuth->addUser("lit", "1233333"));

//判断用户是否存在
var_dump($easyAuth->userExists("lit"));

//判断用户是否存在
var_dump($easyAuth->userExists("abb"));

//获取用户信息
var_dump($easyAuth->getUserInfo("lit"));
var_dump($easyAuth->getUserInfo("abb"));

//验证用户登录
var_dump($easyAuth->checkLogin("lit", "1233333"));
var_dump($easyAuth->checkLogin("lit", "12332333"));

//是否有注册用户
var_dump($easyAuth->hasUser());

//删除用户
$easyAuth->delUser("lit");
$easyAuth->delUser("abb");

//获取用户信息保存目录
var_dump($easyAuth->getDataBaseDir());