### 文件监听

````php
use  \Lit\Utils\LiFileListen;
````

### 监听文件新增行

````php
# 监听文件 __DIR__ . "/test.txt" 并把新增行传给 回调函数的参数 $line
# 支持多个文件监听
* 注意同一行后追加字符 不会判断为新增行
* 启动时如果被监听文件有内容 会先输出文件的最后一行 

$fileListen = new LiFileListen([
    __DIR__ . "/test.txt" => function ($line) {
        var_dump($line);
    }
]);
$fileListen->run();
````