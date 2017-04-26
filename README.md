litool PHP
==============
litool PHP 帮助文件.

### 贡献代码
    - 如果您有任何,请在git issure 中创建问题或者自由创建分支.

### 目录
1. [liarray 数组](https://code.aliyun.com/lit/litool#%E6%95%B0%E7%BB%84%E9%83%A8%E5%88%86) <br />

### 安装
litool PHP 需要使用 composer 进行安装.

```php
"require" : {
    ...
    "lit/litool": "dev-master"
}
```

### 使用方法

#### 数组部分

```php
require(__DIR__.'/vendor/autoload.php');
use  \lit\litool\liarray;

#通过正则表达式匹配一维数组的值,返回正则表达式匹配部分
var_dump ( liarray::RegexArray (['aa','bb','cc','ab','ac'],'/^a/') );
```
