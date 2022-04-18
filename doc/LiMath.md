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