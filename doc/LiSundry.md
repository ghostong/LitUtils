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