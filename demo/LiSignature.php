<?php

require(dirname(__DIR__) . '/vendor/autoload.php');

################################

#接口HTTP访问签名验证

#服务端验证访问
$sign = new \Lit\Utils\LiSignature();
//自定义参与运算的 accessKeyId accessKeySecret
$accessData["accessKeyId"] = "accessKeySecret";
$accessData["accessKeyId2"] = "accessKeySecret2";
$accessData["accessKeyId3"] = "accessKeySecret4";
//获取其他参数
$urlPath = "/api/aaa";
$get = $_GET;
$post = $_POST;
$accessKeySecret = $accessData[$get["AccessKeyId"]];
var_dump($sign->checkSignature($urlPath, $accessKeySecret, $get, $post, 'callBackFunction'));
var_dump($sign->getSignatureString());
var_dump($sign->getErrorString());

function callBackFunction($signatureNonce) {
    //此函数需自行实现, 用于防止网络重放攻击.
    //$signatureNonce 为不重复字符串, 使用过返回true, 没有使用过返回false
    //可把此值保存至redis或者memcache等数据库中并设置有效或定时清理
    return false;
}

#客户端访问构建
//GET参数
$sign->addGetParam("AccessKeyId", "accessKeyId");
$sign->addGetParam("Version", "version");
$sign->addGetParam("SignatureNonce", "signaturenonce");
$sign->addGetParam("Timestamp", time());
$sign->addGetParam("OtherParam", "aa");
$sign->addGetParam("OtherParam2", "bb");
//POST参数(可选)
$sign->addPostParam("aa", "bb");
$sign->addPostParam("bb", "bb");
$sign->addPostParam("cc", "cc");
var_dump($url = $sign->getQueryUrl("http://192.168.11.187:9000", "/testServer.php", "accessKeySecret"));

#获取待签名字符串 调试用
var_dump($sign->getSignatureString());

#获取错误代码
var_dump($sign->getErrorCode());

#获取错误提示
var_dump($sign->getErrorString());

#请求方式示例
var_dump((new \Lit\Utils\LiHttp())->get($url)->send());
