### 接口HTTP访问签名验证

#### 服务端验证访问

````php
// 自定义参与运算的 accessKeyId accessKeySecret 此处应从数据库中取出
$accessData["accessKeyId"] = "accessKeySecret";
$accessData["accessKeyId2"] = "accessKeySecret2";
$accessData["accessKeyId3"] = "accessKeySecret4";
$accessKeySecret = $accessData[$_GET["AccessKeyId"]];

// 服务端签名验证
$sign = new \Lit\Utils\LiSignature();
$urlPath = "/api/aaa";
var_dump($sign->checkSignature($urlPath, $accessKeySecret, $_GET, $_POST, 'callBackFunction'));
var_dump($sign->getSignatureString());
var_dump($sign->getErrorString());

//此函数需自行实现, 用于防止网络重放攻击.
function callBackFunction($signatureNonce) {
    //$signatureNonce 为不重复字符串, 使用过返回true, 没有使用过返回false
    //可把此值保存至redis或者memcache等数据库中并设置有效或定时清理
    return false;
}
````

#### 客户端访问构建

````php
//构建GET请求参数
$sign->addGetParam("AccessKeyId", "accessKeyId");
$sign->addGetParam("Version", "version");
$sign->addGetParam("SignatureNonce", "signaturenonce");
$sign->addGetParam("Timestamp", time());
$sign->addGetParam("OtherParam", "aa");
$sign->addGetParam("OtherParam2", "bb");

//构建POST请求参数(可选)
$sign->addPostParam("aa", "bb");
$sign->addPostParam("bb", "bb");
$sign->addPostParam("cc", "cc");

//发起请求
var_dump($url = $sign->getQueryUrl("http://192.168.11.187:9000", "/testServer.php", "accessKeySecret"));
````

#### 获取待签名字符串 调试用

````php
var_dump($sign->getSignatureString());
````

#### 获取错误代码

````php
var_dump($sign->getErrorCode());
````

#### 获取错误提示

````php
var_dump($sign->getErrorString());
````

#### 请求方式示例

````php
var_dump((new \Lit\Utils\LiHttp())->get($url)->send());
````