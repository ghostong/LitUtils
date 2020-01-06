litool PHP
==============
litool PHP 帮助文件.

### 写在前面
    - 此项目出生是为了"实现一些常用又不内置的PHP方法(函数)".
    - 部分代码前面加 "-" 是因为在没处理好代码缩进之前解决代码易读问题.个人感觉比加全角空格更合理.
    - LiInit::Class2Function() 会覆盖现有文件( 默认为 dirname(__DIR__).'/functions.php' ),使用时请注意备份旧文件.
    - 项目目录中的 demo.php 可以直观的帮助理解代码.
    - 如果您有任何,请在git issure 中创建问题或者自由创建分支.

### 安装

1. composer 安装
```php
#编辑composer.json文件
- "require" : {
-     ...
-     "lit/litool": "dev-master"
- }
#安装后使用文档中的调用方法即可使用.
```

2. 源码下载安装 
```php
#引入litool代码
- spl_autoload_register( 'liSplLoadLitool' );
- spl_autoload_extensions( '.php' );
- function liSplLoadLitool ( $ClassName ) {
-     $IncludePath = __DIR__.DIRECTORY_SEPARATOR.'src';
-     set_include_path( get_include_path().':'.$IncludePath );  #此处为代码包中litool/src路径,必要时请手动修改
-     $ClassFile = end (explode('\\',$ClassName));
-     spl_autoload ($ClassFile);
- }
#安装后使用文档中的调用方法即可使用.
```

### 使用方法

#### 初始化
````php
require(__DIR__.'/vendor/autoload.php');
use  \Lit\Litool\LiInit;

#初始化:判断是否有依赖未安装 使用前运行一次即可
LiInit::init();

#类转函数,方便非composer安装与快速调用[此方法会生成文件,默认为 dirname(__DIR__).'/functions.php']
LiInit::Class2Function();
````

#### 数组部分

````php
require(__DIR__.'/vendor/autoload.php');
use  \Lit\Litool\LiArray;

#通过正则表达式匹配一维数组的值,返回正则表达式匹配部分
var_dump ( LiArray::regexArray (['aa','bb','cc','ab','ac'],'/^a/') );

#归替换多维数中指定的字符串
var_dump (LiArray::arrayReplace('a','b',['aacd','aag','have','aa'=>['cba']]));

#标准的XML解析成数组
$xml = '<?xml version="1.0" encoding="UTF-8"?> <note><to>Tove</to><from>Jani</from><heading>Reminder</heading></note>';
var_dump (LiArray::xmlToArray($xml));

````

#### 字符串部分

````php
require(__DIR__.'/vendor/autoload.php');
use  \Lit\Litool\LiString;

#获取随机数字符串
var_dump ( LiString::randStr(8,true,true,true,true) );

#返回 haystack 在首次 needle 出现之前的字符串
var_dump ( LiString::subStrTo('i can say my abc !',' my') );

#简单字符串可逆加密(加密)
$Encode = LiString::strEncode('可逆运算');
var_dump ( $Encode );

#简单字符串可逆加密(解密)
$Decode = LiString::strDecode($Encode);
var_dump ( $Decode );

````

#### 日期时间部分

````php
require(__DIR__.'/vendor/autoload.php');
use  \Lit\Litool\LiDate;

#返回当前时间以秒为单位的微秒数
var_dump ( LiDate::microTime() );

#回当前时间以秒为单位的毫秒数
var_dump ( LiDate::milliTime() );

#返回中文格式化的时间
var_dump ( LiDate::dateFormat('1494475359') );

#返回下个月是几月
var_dump ( LiDate::nextMonth('2015-2-28') );

#返回上个月是几月
var_dump ( LiDate::lastMonth('2015-01-01') );

#返回今天还剩多少秒
var_dump ( LiDate::todayRemainTime() );

````

#### 数学函数部分
````php
require(__DIR__.'/vendor/autoload.php');
use  \Lit\Litool\LiMath;

#10进制转62进制
var_dump ( LiMath::base10to62(40000) );

#62进制转10进制
var_dump ( LiMath::base62to10('ACG97') );

#数字是否在两个数中间(包含边界)
var_dump ( LiMath::between(6,1,6) );
````

#### 杂项部分
````php
require(__DIR__.'/vendor/autoload.php');
use  \Lit\Litool\LiSundry;

#获取用户来源IP
var_dump ( LiSundry::getRemoteAddr() );

#发送http状态码
LiSundry::sendHttpStatus(404) ;

#根据权重随机返回备选数据
$wd = array (
    array ( 'w' => 60, 'v' => '我是60%概率') ,
    array ( 'w' => 35, 'v' => '我是35%概率') ,
    array ( 'w' => 5 , 'v' => '我是5%概率') ,
);
var_dump ( LiSundry::getWeight( $wd ) );

#判断是否私网IP
var_dump ( LiSundry::isLocalIp('10.25.11.58') );

#判断是否18位身份证号
var_dump ( LiSundry::isIdNumber18('130602199001011111',1) );

#判断是否15位身份证号
var_dump ( LiSundry::isIdNumber15('110100010923582',0) );

````

#### 简单用户系统
    注意: 此系统只适用于简单身份认证,不适合高并发,大数据量,高安全性的用户系统

````php
#单例获取 LiEasyAuth 对象
$easyAuth = \Lit\Litool\LiEasyAuth::getInstance("/tmp/aaa");

#创建一个用户
var_dump ( $easyAuth->AddUser("lit","1233333") );

#判断用户是否存在
var_dump ( $easyAuth->UserExists("lit") );

#判断用户是否存在
var_dump ( $easyAuth->UserExists("abb") );

#获取用户信息
var_dump ( $easyAuth->getUserInfo("lit"));
var_dump ( $easyAuth->getUserInfo("abb"));

#验证用户登录
var_dump ( $easyAuth->CheckLogin("lit","1233333"));
var_dump ( $easyAuth->CheckLogin("lit","12332333"));

#是否有注册用户
var_dump ($easyAuth->hasUser());

#删除用户
$easyAuth->DelUser("lit");
$easyAuth->DelUser("abb");

#获取用户信息保存目录
var_dump ( $easyAuth->getDataBaseDir() );
````