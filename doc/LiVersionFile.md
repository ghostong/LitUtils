### 带历史版本的文件操作

#### 1. 创建[修改]文件并保留历史

````php
try {
    $file = \Lit\Utils\LiVersionFile::put("./tmp", date("YmdHi") . '.txt', './version/', uniqid());
    var_dump($file);
} catch (Exception $e) {
    var_dump($e->getCode(), $e->getMessage());
}
````

#### 2. 删除指定版本的文件

````php
try {
    $file = \Lit\Utils\LiVersionFile::deleteVersionFile("./version", '202012181009.txt.ver.2020121810093031802537');
    var_dump($file);
} catch (Exception $e) {
    var_dump($e->getCode(), $e->getMessage());
}
````

#### 3. 显示某文件历史记录

````php
try {
    $list = \Lit\Utils\LiVersionFile::versionFileList('./version', '20201218093840.txt');
    foreach ($list as $file) {
        echo $file, "\n";
    }
} catch (Exception $e) {
    var_dump($e->getCode(), $e->getMessage());
}
````