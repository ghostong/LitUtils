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

#### 4. 判断IP

````php
//同 isPrivateIp
var_dump ( LiSundry::isLocalIp('10.25.11.58') );
//bool(true)

//是否IP
var_dump(LiSundry::isIp("8.8.8.8"));
//bool(true)

//是否IPV4
var_dump(LiSundry::isIpV4("8.8.8.8"));
//bool(true)

//是否IP6
var_dump(LiSundry::isIpV6("FF00::"));
//bool(true)

//是否内网IP
var_dump(LiSundry::isPrivateIp("127.0.0.1"));
//bool(true)

//是否内网IPV4
var_dump(LiSundry::isPrivateIpV4("9.0.0.1"));
//bool(false)

//是否内网IPV6
var_dump(LiSundry::isPrivateIpV6("::"));
//bool(true)
````

#### 5. 判断是否18位身份证号

````php
var_dump ( LiSundry::isIdNumber('130602199001011111',1) );
//bool(true)
````

#### 6. 是否邮箱

````php
var_dump(LiSundry::isEmail("a@b.com"));
//bool(true)
````

#### 7. 下载header

````php
var_dump (LiSundry::downLoadHeader("压缩包.zip", "application/zip", "UTF-8", true));
//发送header并返回所使用header数组
````