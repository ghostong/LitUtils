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