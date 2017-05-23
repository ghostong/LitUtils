litool PHP
==============
litool PHP 帮助文件.

### 贡献代码
    - 如果您有任何,请在git issure 中创建问题或者自由创建分支.

### 目录
0. [liinit 初始化](https://code.aliyun.com/lit/litool#%e5%88%9d%e5%a7%8b%e5%8c%96) <br />
1. [liarray 数组](https://code.aliyun.com/lit/litool#%E6%95%B0%E7%BB%84%E9%83%A8%E5%88%86) <br />
2. [listring 字符串](https://code.aliyun.com/lit/litool#%e5%ad%97%e7%ac%a6%e4%b8%b2%e9%83%a8%e5%88%86) <br />
3. [lidate 日期时间](https://code.aliyun.com/lit/litool#%e6%97%a5%e6%9c%9f%e6%97%b6%e9%97%b4%e9%83%a8%e5%88%86) <br />
4. [limath  数学函数](https://code.aliyun.com/lit/litool#%E6%95%B0%E5%AD%A6%E5%87%BD%E6%95%B0%E9%83%A8%E5%88%86) <br />
5. [lisundry  杂项](https://code.aliyun.com/lit/litool#%D4%D3%CF%EE%B2%BF%B7%D6) <br />

### 安装
litool PHP 需要使用 composer 进行安装.

```php
"require" : {
    ...
    "lit/litool": "dev-master"
}
```

### 使用方法

#### 初始化
```php
require(__DIR__.'/vendor/autoload.php');
use  \lit\litool\liinit;

#初始化:判断是否有依赖未安装 使用前运行一次即可
liinit::init();
```

#### 数组部分

```php
require(__DIR__.'/vendor/autoload.php');
use  \lit\litool\liarray;

#通过正则表达式匹配一维数组的值,返回正则表达式匹配部分
var_dump ( liarray::RegexArray (['aa','bb','cc','ab','ac'],'/^a/') );

#归替换多维数中指定的字符串
var_dump (liarray::ArrayReplace('a','b',['aacd','aag','have','aa'=>['cba']]));

```

#### 字符串部分

```php
require(__DIR__.'/vendor/autoload.php');
use  \lit\litool\listring;

#获取随机数字符串
var_dump ( listring::RandStr(8,true,true,true,true) );

#返回 haystack 在首次 needle 出现之前的字符串
var_dump ( listring::SubStrTo('i can say my abc !',' my') );

#简单字符串可逆加密(加密)
$Encode = listring::StrEncode('可逆运算');
var_dump ( $Encode );

#简单字符串可逆加密(解密)
$Decode = listring::StrDecode($Encode);
var_dump ( $Decode );

```

#### 日期时间部分

```php
require(__DIR__.'/vendor/autoload.php');
use  \lit\litool\lidate;

#返回当前时间以秒为单位的微秒数
var_dump ( lidate::MicroTime() );

#回当前时间以秒为单位的毫秒数
var_dump ( lidate::MilliTime() );

#返回中文格式化的时间
var_dump ( lidate::DateFormat('1494475359') );

#返回下个月是几月
var_dump ( lidate::NextMonth('2015-2-28') );

#返回上个月是几月
var_dump ( lidate::LastMonth('2015-01-01') );

```

#### 数学函数部分
```php
require(__DIR__.'/vendor/autoload.php');
use  \lit\litool\limath;

#10进制转62进制
var_dump ( limath::Base10to62(40000) );

#62进制转10进制
var_dump ( limath::Base62to10('ACG97') );
```

#### 杂项部分
```php
use  \lit\litool\lisundry;

#获取用户来源IP
var_dump ( lisundry::GetRemoteAddr() );
```
