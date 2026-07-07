<?php

require(dirname(__DIR__) . '/vendor/autoload.php');

use \Lit\Utils\LiApcu;

# 初始化
LiApcu::init(array(
    "apc.enable_cli" => "1",
    "apc.shm_size" => "128M",
    "apc.entries_hint" => "4096",
    "apc.ttl" => "0",
    "apc.gc_ttl" => "3600",
    "max_value_size" => "2M",
));

# 设置缓存
LiApcu::set("name", "lit", 60);

# 获取缓存
$success = false;
var_dump(LiApcu::get("name", $success), $success);

# 判断缓存是否存在
var_dump(LiApcu::exists("name"));

# 自增缓存
LiApcu::set("counter", 1);
var_dump(LiApcu::inc("counter"));

# 获取并设置缓存
var_dump(LiApcu::remember("remember_key", function () {
    return "remember_value";
}, 60));

# 删除缓存
var_dump(LiApcu::del("name"));
