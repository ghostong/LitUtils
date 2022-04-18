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