<?php

require(dirname(__DIR__) . '/vendor/autoload.php');

################################

//HTTP请求
$http = new \Lit\Utils\LiHttp();

//发送一个GET请求
$response = $http->setParam(["a" => 1])->get("http://www.google.com?b=2")->send();

//发送一个POST请求
$response = $http->setParam(["a" => 1])->post("http://www.google.com?b=2")->send();
var_dump($response);

//POST JSON
$response = $http->postJson("http://www.google.com", "{}")->setHeader(["aa:11"])->send();
var_dump($response);

//发送一个文件上传
$response = $http->setParam(["a" => 1])->postFile(["file" => "/Users/Desktop/comic.zip", "file2" => "/Users/Desktop/2.jpg"])->post("http://google.com")->send();
var_dump($response);

//发送一个文件下载
$response = $http->get("https://www.google.com/aaa.jpg")->setSavePath("./aaa.jpg")->download(false);
var_dump($response);

//获取结果
var_dump($http->getErrNo()); //获取错误码
var_dump($http->getErrMsg()); //获取错误信息
var_dump($http->getHttpCode()); //获取http状态码
var_dump($http->getHttpResult()); //获取返回值
