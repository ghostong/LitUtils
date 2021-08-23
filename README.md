LitUtils PHP
==============
LitUtils PHP 帮助文件.

## 写在前面

    - 此项目出生是为了"实现一些常用又不内置的PHP方法(函数)".
    - 项目目录中的 demo.php 可以直观的帮助理解代码.
    - 如果您有任何,请在git issure 中创建问题或者自由创建分支.

## 安装

```
composer require lit/utils
```

## 使用方法

### 数组部分

````php
use  \Lit\Utils\LiArray;
````

#### 1. 通过正则表达式匹配一维数组的值,返回正则表达式匹配部分

````php
var_dump ( LiArray::regexArray (['aa','bb','cc','ab','ac'],'/^a/') );
//array(3) {
//  [0]=>
//  string(2) "aa"
//  [3]=>
//  string(2) "ab"
//  [4]=>
//  string(2) "ac"
//}
````

#### 2. 递归替换多维数中指定的字符串

````php
var_dump (LiArray::arrayReplace('a','b',['aacd','aag','have','aa'=>['cba']]));
//array(4) {
//  [0]=>
//  string(4) "bbcd"
//  [1]=>
//  string(3) "bbg"
//  [2]=>
//  string(4) "hbve"
//  ["aa"]=>
//  array(1) {
//    [0]=>
//    string(3) "cbb"
//  }
//}
````

#### 3. 标准的XML解析成数组

````php
$xml = '<?xml version="1.0" encoding="UTF-8"?> <note><to>Tove</to><from>Jani</from><heading>Reminder</heading></note>';
var_dump (LiArray::xmlToArray($xml));
//array(3) {
//  ["to"]=>
//  string(4) "Tove"
//  ["from"]=>
//  string(4) "Jani"
//  ["heading"]=>
//  string(8) "Reminder"
//}
````

#### 4. 获取一维数组指定的keys对应的值

````php
var_dump(LiArray::getValues(["a" => 1, "b" => 2, "c" => 3, "d" => 4], ["a", "c"]));
//array(2) {
//  ["a"]=>
//  int(1)
//  ["c"]=>
//  int(3)
//}
````

#### 5. 通过一个数组去排序另外一个数组

````php
$a = ["key" => "key1", "val" => "val2", "good" => "good3",1=>"11",0]; //待排序的数组
$b = ["good", "key",1,"val"]; //想要的顺序
var_dump ( LiArray::sortByArray($a, $b) );
//array(5) {
//  ["good"]=>
//  string(5) "good3"
//  ["key"]=>
//  string(4) "key1"
//  [1]=>
//  string(2) "11"
//  ["val"]=>
//  string(4) "val2"
//  [2]=>
//  int(0)
//}
````

#### 6. 别名一维数组的键名

````php
var_dump(LiArray::keyAlias(["_id" => 1, "_name" => "测试"], ["_id" => "id", "_name" => "name"]));
//array(2) {
//  ["id"]=>
//  int(1)
//  ["name"]=>
//  string(6) "测试"
//}
````

#### 7. 根据二维数组的键名分组

````php
$array = [
    ["name" => "小美", "group_id" => "2"], ["name" => "小帅", "group_id" => "1"],
    ["name" => "阿呆", "group_id" => "2"], ["name" => "阿花", "group_id" => "1"],
    ["name" => "烧饼", "group_name" => "3"],
];
var_dump(LiArray::groupByKey($array, "group_id", "other_group"));
````

### 字符串部分

````php
use  \Lit\Utils\LiString;
````

#### 1. 汉字转阿拉伯数字

````php
var_dump( LiString::str2num('九千五百一十三兆九千零三亿一千零二十七万零二佰五十') );
//int(9513900310270250)
````

#### 2. 获取随机数字符串

````php
var_dump ( LiString::randStr(8,true,true,true,true) );
//string(8) "to6HG!w6"
````

#### 3. 返回 haystack 在首次 needle 出现之前的字符串

````php
var_dump ( LiString::subStrTo('i can say my abc !',' my') );
//string(9) "i can say"
````

#### 4. 简单字符串可逆加密(加密)

````php
var_dump ( LiString::strEncode('可逆运算') );
//string(16) "Y6D+65K6L5i+L6TP"
````

#### 5. 简单字符串可逆加密(解密)

````php
var_dump ( LiString::strDecode("Y6D+65K6L5i+L6TP") );
//string(12) "可逆运算"
````

#### 6. 限制字符串的字符数量

````php
var_dump(LiString::strLimit('不a管b什么样的字符都可以了', 7));
//string(11) "不a管b..."
````

#### 7. 替换字符串中的变量占位符

````php
var_dump(LiString::replaceStringVariable('我叫{$name}', array('name' => 'litool')));
//string(12) "我叫litool"
````

#### 8. 下划线字符串转驼峰字符串

````php
var_dump(LiString::toCamelCase("hello_my_name_is8a_h5_array"));
//string(22) "helloMyNameIs8aH5Array"
````

#### 9. 驼峰字符串转下划线字符串

````php
var_dump(LiString::toUnderScoreCase("HelloMyNameIs8aH5Array"));
//string(26) "hello_my_name_is8a_h5array"
````

#### 10. 一维数组转原生SQL

````php
var_dump(LiString::array2sql(["name" => "test", "id" => 12],"table1", "database"));
//string(71) "insert into `database`.`table1` ( `name`, `id` ) values ( "test", "12" )"
````

#### 11. 从字符串中提取ID

````php
var_dump(LiString::getIdsByStr("123\n9900,1231,4333分割889"));
//array(5) {
//  [0]=>
//  string(3) "123"
//  [1]=>
//  string(4) "9900"
//  [2]=>
//  string(4) "1231"
//  [3]=>
//  string(4) "4333"
//  [4]=>
//  string(3) "889"
//}
````

#### 12. 判断UTF-8字符串是否含有乱码

````php
var_dump(LiString::hasMessyCodes("是否含有乱码"));
//bool(false)
````

#### 13. GB18030 字符集转 UTF-8 字符集

````php
var_dump(LiString::gb2u("GB18030 Code"));
//string(10) "UTF-8 Code"
````

#### 14. UTF-8 字符集转 GB18030 字符集

````php
var_dump(LiString::u2gb("UTF-8 Code"));
//string(12) "GB18030 Code"
````

### 日期时间部分

````php
use  \Lit\Utils\LiDate;
````

#### 1. 返回当前时间以秒为单位的微秒数

````php
var_dump ( LiDate::microTime() );
//string(17) "1623396847.630771"
````

#### 2. 回当前时间以秒为单位的毫秒数

````php
var_dump ( LiDate::milliTime() );
//string(14) "1623396847.631"
````

#### 3. 返回中文格式化的时间

````php
var_dump ( LiDate::dateFormat(time()-mt_rand(1,9999)) );
//string(10) "1分钟前"
````

#### 4. 返回下个月是几月

````php
var_dump ( LiDate::nextMonth('2015-2-28') );
//string(7) "2015-03"
````

#### 5. 返回上个月是几月

````php
var_dump ( LiDate::lastMonth('2015-01-01') );
//string(7) "2014-12"
````

#### 6. 返回今天还剩多少秒

````php
var_dump ( LiDate::todayRemainTime() );
//int(58922)
````

### 数学函数部分

````php
use  \Lit\Utils\LiMath;
````

#### 1. 10进制转62进制

````php
var_dump ( LiMath::base10to62(40000) );
//string(3) "apa"
````

#### 2. 62进制转10进制

````php
var_dump ( LiMath::base62to10('ACG97') );
//int(541166573)
````

#### 3. 数字是否在两个数中间(包含边界)

````php
var_dump ( LiMath::between(6,1,6) );
//bool(true)
````

### 杂项部分

````php
use  \Lit\Utils\LiSundry;
````

#### 1. 获取用户来源IP

````php
var_dump ( LiSundry::getRemoteAddr() );
//string(7) "192.168.1.123"
````

#### 2. 发送http状态码

````php
LiSundry::sendHttpStatus(404) ;
````

#### 3. 根据权重随机返回备选数据

````php
$wd = array (
    array ( 'w' => 60, 'v' => '我是60%概率') ,
    array ( 'w' => 35, 'v' => '我是35%概率') ,
    array ( 'w' => 5 , 'v' => '我是5%概率') ,
);
var_dump ( LiSundry::getWeight( $wd ) );
//string(15) "我是35%概率"
````

#### 4. 判断是否私网IP

````php
var_dump ( LiSundry::isLocalIp('10.25.11.58') );
//bool(true)
````

#### 5. 判断是否18位身份证号

````php
var_dump ( LiSundry::isIdNumber('130602199001011111',1) );
//bool(true)
````

### 简单用户系统

    注意: 此系统只适用于简单身份认证,不适合高并发,大数据量,高安全性的用户系统

#### 单例获取 LiEasyAuth 对象

````php
$easyAuth = \Lit\Utils\LiEasyAuth::getInstance("/opt/data/cache/easyAuth");
````

#### 1. 创建一个用户

````php
var_dump ( $easyAuth->addUser("lit","1233333") );
````

#### 2. 判断用户是否存在

````php
var_dump ( $easyAuth->userExists("lit") );
````

#### 3. 判断用户是否存在

````php
var_dump ( $easyAuth->userExists("abb") );
````

#### 4. 获取用户信息

````php
var_dump ( $easyAuth->getUserInfo("lit"));
var_dump ( $easyAuth->getUserInfo("abb"));
````

#### 5. 验证用户登录

````php
var_dump ( $easyAuth->checkLogin("lit","1233333"));
var_dump ( $easyAuth->checkLogin("lit","12332333"));
````

#### 6. 是否有注册用户

````php
var_dump ($easyAuth->hasUser());
````

#### 7. 删除用户

````php
$easyAuth->delUser("lit");
$easyAuth->delUser("abb");
````

#### 8. 获取用户信息保存目录

````php
var_dump ( $easyAuth->getDataBaseDir() );
````

### 接口HTTP访问签名验证

````php
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
var_dump ( $sign->checkSignature($urlPath, $accessKeySecret, $get, $post , 'callBackFunction' ));
var_dump ( $sign->getSignatureString());
var_dump ( $sign->getErrorString() );

function callBackFunction ( $signatureNonce ) {
    //此函数需自行实现, 用于防止网络重放攻击.
    //$signatureNonce 为不重复字符串, 使用过返回true, 没有使用过返回false
    //可把此值保存至redis或者memcache等数据库中并设置有效或定时清理
    return false;
}

#客户端访问构建
//GET参数
$sign->addGetParam("AccessKeyId","accessKeyId");
$sign->addGetParam("Version","version");
$sign->addGetParam("SignatureNonce","signaturenonce");
$sign->addGetParam("Timestamp",time() );
$sign->addGetParam("OtherParam","aa");
$sign->addGetParam("OtherParam2","bb");
//POST参数(可选)
$sign->addPostParam("aa","bb");
$sign->addPostParam("bb","bb");
$sign->addPostParam("cc","cc");
#获取待请求url
var_dump ( $url= $sign->getQueryUrl("http://192.168.11.187:9000","/testServer.php","accessKeySecret" ) );

#获取待签名字符串 调试用
var_dump ($sign->getSignatureString());

#获取错误代码
var_dump ( $sign->getErrorCode() );

#获取错误提示
var_dump ( $sign->getErrorString() );

#请求方式示例
var_dump ( (new \Lit\Utils\LiHttp())->get($url)->send() );
````

### 带历史版本的文件操作文件

#### 1. 创建[修改]文件并保留历史

````php
try {
    $file = \Lit\Utils\LiVersionFile::put("./tmp", date("YmdHi") . '.txt', './version/', uniqid());
    var_dump($file);
} catch (Exception $e) {
    var_dump($e->getCode(), $e->getMessage());
}
````

#### 2. 删除指定版本的文件

````php
try {
    $file = \Lit\Utils\LiVersionFile::deleteVersionFile("./version", '202012181009.txt.ver.2020121810093031802537');
    var_dump($file);
} catch (Exception $e) {
    var_dump($e->getCode(), $e->getMessage());
}
````

#### 3. 显示某文件历史记录

````php
try {
    $list = \Lit\Utils\LiVersionFile::versionFileList('./version', '20201218093840.txt');
    foreach ($list as $file) {
        echo $file, "\n";
    }
} catch (Exception $e) {
    var_dump($e->getCode(), $e->getMessage());
}
````

### HTTP请求

````php
$http = new \Lit\Utils\LiHttp();
````

#### 1. 发送一个GET请求

````php
$response = $http->setParam(["a" => 1])->get("http://www.google.com?b=2")->send();
var_dump($response);
````

#### 2. 发送一个POST请求

````php
$response = $http->setParam(["a" => 1])->post("http://www.google.com?b=2")->send();
var_dump($response);
````

#### 3. POST JSON

````php
$response = $http->postJson("http://www.google.com", "{}")->setHeader(["aa:11"])->send();
var_dump($response);
````

#### 4. 发送一个文件上传

````php
$response = $http->setParam(["a" => 1])->postFile(["file" => "/Users/Desktop/comic.zip", "file2" => "/Users/Desktop/2.jpg"])->post("http://google.com")->send();
var_dump($response);
````

#### 5. 发送一个文件下载

````php
$response = $http->get("https://www.google.com/aaa.jpg")->setSavePath("./aaa.jpg")->download(false);
var_dump($response);
````

### 数据映射

#### 1. 基础类(数据模型)

````php
class TestMapper extends \Lit\Utils\LiMapper
{
    protected $a = 1;
    protected $b = 2;
    protected $c = 3;
    protected $d = 3;
}
````

#### 2.通过属性实例化

````php
$newMapper = new TestMapper();
$newMapper->a = 30;
$newMapper->d = 50;

var_dump($newMapper->getUpdate()); //获取修改数据
//array(2) {
//  ["a"]=>
//  int(30)
//  ["d"]=>
//  int(50)
//}

var_dump($newMapper->getInsert()); //获取写入数据
//array(4) {
//  ["a"]=>
//  int(30)
//  ["b"]=>
//  int(2)
//  ["c"]=>
//  int(3)
//  ["d"]=>
//  int(50)
//}
````

#### 3.通过参数实例化

````php
$newMapper = new TestMapper(["a" => 10, "b" => "15"]);
var_dump($newMapper->getUpdate()); //获取修改数据
//array(2) {
//  ["a"]=>
//  int(10)
//  ["b"]=>
//  string(2) "15"
//}

var_dump($newMapper->getInsert()); //获取写入数据
//array(4) {
//  ["a"]=>
//  int(10)
//  ["b"]=>
//  string(2) "15"
//  ["c"]=>
//  int(3)
//  ["d"]=>
//  int(3)
//}
````

### 进程内数据缓存

    用于全局数据传输, 避免污染 $GLOBALS

````php
use  \Lit\Utils\LiTransit;
````

#### 1. 写入一条缓存

````php
var_dump(LiTransit::set("a", 2));
````

#### 2. 不存在时写入一条缓存

````php
var_dump(LiTransit::setNX("a", 4));
````

#### 3. 获取一条缓存

````php
var_dump(LiTransit::get("a"));
````

#### 4. 判断缓存是否存在

````php
var_dump(LiTransit::exists("c"));
````

#### 5. 删除缓存数据

````php
var_dump(LiTransit::rm("b"));
````

#### 6. 获取所有缓存数据

````php
var_dump(LiTransit::getAll());
````
