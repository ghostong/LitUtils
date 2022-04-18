
### 文件缓存

#### 1. 初始化

````php
use  \Lit\Utils\LiFileCache;

#指定缓存保存目录
LiFileCache::init("/tmp");
````

#### 2. 设置缓存

````php
LiFileCache::set("abc", [1, 2, 3], 10);
````

#### 3. 获取缓存

````php
var_dump(LiFileCache::get("abc"));
````

#### 4. 删除缓存

````php
var_dump(LiFileCache::del("abc"));
````

#### 5. 判断缓存是否存在

````php
var_dump(LiFileCache::exists("bbc"));
````