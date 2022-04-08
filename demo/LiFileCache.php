<?php

require(dirname(__DIR__) . '/vendor/autoload.php');

use  \Lit\Utils\LiFileCache;

# 初始化
LiFileCache::init("/tmp");

# 设置缓存
LiFileCache::set("abc", [1, 2, 3], 10);

# 获取缓存
var_dump(LiFileCache::get("abc"));

# 删除缓存
var_dump(LiFileCache::del("abc"));

# 判断缓存是否存在
var_dump(LiFileCache::exists("bbc"));