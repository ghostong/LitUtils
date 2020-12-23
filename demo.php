<?php

require(__DIR__ . '/vendor/autoload.php');

################################

use  \Lit\Utils\LiArray;

#通过正则表达式匹配一维数组的值,返回正则表达式匹配部分
var_dump(LiArray::regexArray(['aa', 'bb', 'cc', 'ab', 'ac'], '/^a/'));

#归替换多维数中指定的字符串
var_dump(LiArray::arrayReplace('a', 'b', ['aacd', 'aag', 'have', 'aa' => ['cba']]));

#标准的XML解析成数组
$xml = '<?xml version="1.0" encoding="UTF-8"?> <note><to>Tove</to><from>Jani</from><heading>Reminder</heading></note>';
var_dump(LiArray::xmlToArray($xml));

################################

use  \Lit\Utils\LiString;

#获取随机数字符串
var_dump(LiString::randStr(8, true, true, true, true));

#返回 haystack 在首次 needle 出现之前的字符串
var_dump(LiString::subStrTo('i can say my abc !', ' my'));

#简单字符串可逆加密(加密)
$Encode = LiString::strEncode('可逆运算');
var_dump($Encode);

#简单字符串可逆加密(解密)
$Decode = LiString::strDecode($Encode);
var_dump($Decode);

#限制字符串的字符数量
var_dump(LiString::strLimit('不a管b什么样的字符都可以了', 7));

#替换字符串中的变量占位符
var_dump(LiString::replaceStringVariable('我叫{$name}', array('name' => 'litool')));

################################

use  \Lit\Utils\LiDate;

#返回当前时间以秒为单位的微秒数
var_dump(LiDate::microTime());

#回当前时间以秒为单位的毫秒数
var_dump(LiDate::milliTime());

#返回中文格式化的时间
var_dump(LiDate::dateFormat('1494475359'));

#返回下个月是几月
var_dump(LiDate::nextMonth('2015-2-28'));

#返回上个月是几月
var_dump(LiDate::lastMonth('2015-01-01'));

#返回今天还剩多少秒
var_dump(LiDate::todayRemainTime());

################################

use  \Lit\Utils\LiMath;

#10进制转62进制
var_dump(LiMath::base10to62(40000));

#62进制转10进制
var_dump(LiMath::base62to10('ACG97'));

#数字是否在两个数中间(包含边界)
var_dump(LiMath::between(6, 1, 6));

################################

use  \Lit\Utils\LiSundry;

#获取用户来源IP
var_dump(LiSundry::getRemoteAddr());

#发送http状态码
LiSundry::sendHttpStatus(404);

#根据权重随机返回备选数据
$wd = array(
    array('w' => 60, 'v' => '我是60%概率'),
    array('w' => 35, 'v' => '我是35%概率'),
    array('w' => 5, 'v' => '我是5%概率'),
);
var_dump(LiSundry::getWeight($wd));

#判断是否私网IP
var_dump(LiSundry::isLocalIp('10.25.11.58'));

#判断是否18位身份证号
var_dump(LiSundry::isIdNumber('130602199001011111', 1));


################################

#单例获取 LiEasyAuth 对象
#注意: 此系统只适用于简单身份认证,不适合高并发,大数据量,高安全性的用户系统
$easyAuth = \Lit\Utils\LiEasyAuth::getInstance("/tmp/aaa");

#创建一个用户
var_dump($easyAuth->addUser("lit", "1233333"));

#判断用户是否存在
var_dump($easyAuth->userExists("lit"));

#判断用户是否存在
var_dump($easyAuth->userExists("abb"));

#获取用户信息
var_dump($easyAuth->getUserInfo("lit"));
var_dump($easyAuth->getUserInfo("abb"));

#验证用户登录
var_dump($easyAuth->checkLogin("lit", "1233333"));
var_dump($easyAuth->checkLogin("lit", "12332333"));

#是否有注册用户
var_dump($easyAuth->hasUser());

#删除用户
$easyAuth->delUser("lit");
$easyAuth->delUser("abb");

#获取用户信息保存目录
var_dump($easyAuth->getDataBaseDir());

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

################################

#带历史版本的文件操作文件
try {
    //创建[修改]文件并保留历史
    $file = \Lit\Utils\LiVersionFile::put("./tmp", date("YmdHi") . '.txt', './version/', uniqid());
    var_dump($file);

    //删除指定版本的文件
    $file = \Lit\Utils\LiVersionFile::deleteVersionFile("./version", '202012181009.txt.ver.2020121810093031802537');
    var_dump($file);

    //显示某文件历史记录
    $list = \Lit\Utils\LiVersionFile::versionFileList('./version', '20201218093840.txt');
    foreach ($list as $file) {
        echo $file, "\n";
    }
} catch (Exception $e) {
    var_dump($e->getCode(), $e->getMessage());
}

################################

#HTTP请求
$http = new \Lit\Utils\LiHttp();
//发送一个GET请求
$response = $http->setParam(["a" => 1])->get("http://www.google.com?b=2")->send();
var_dump($response);

//发送一个POST请求
$response = $http->setParam(["a" => 1])->post("http://www.google.com?b=2")->send();
var_dump($response);

//发送一个文件上传
$response = $http->setParam(["a" => 1])->postFile(["file" => "/Users/Desktop/comic.zip", "file2" => "/Users/Desktop/2.jpg"])->post("http://google.com")->send();
var_dump($response);
