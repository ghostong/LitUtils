
### APCu 缓存

#### 1. 初始化

````php
use \Lit\Utils\LiApcu;

LiApcu::init(array(
    "apc.enable_cli" => "1",
    "apc.shm_size" => "128M",
    "apc.entries_hint" => "4096",
    "apc.ttl" => "0",
    "apc.gc_ttl" => "3600",
    "max_value_size" => "2M",
));
````

`apc.shm_size` 表示 APCu 可用共享内存总量, `max_value_size` 为 LiApcu 自定义配置, 表示单个缓存值最大字节数, 支持 `K`、`M`、`G` 单位, `0` 表示不限制.

#### 2. 设置缓存

````php
LiApcu::set("name", "lit", 60);
````

#### 3. 获取缓存

````php
$success = false;
$value = LiApcu::get("name", $success);
var_dump($success, $value);
````

#### 4. 判断缓存是否存在

````php
var_dump(LiApcu::exists("name"));
````

#### 5. 删除缓存

````php
var_dump(LiApcu::del("name"));
````

#### 6. 获取并设置缓存

````php
$value = LiApcu::remember("user_count", function () {
    return 100;
}, 60);
````

#### 7. 自增和自减

````php
LiApcu::set("counter", 1);
LiApcu::inc("counter");
LiApcu::dec("counter");
````

#### 8. 清空缓存

````php
LiApcu::clear();
````

#### 9. 查看缓存信息

````php
var_dump(LiApcu::cacheInfo(true));
var_dump(LiApcu::smaInfo(true));
````
