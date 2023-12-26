### 文件操作

````php
use  \Lit\Utils\LiFileOperator;
````

#### 递归(选填)列出目录中所有的文件

````php
var_dump(LiFileOperator::listFiles(dirname(__DIR__), true));
````

#### 递归(选填)列出目录中所有的目录

````php
var_dump(LiFileOperator::listDirs(dirname(__DIR__), true));
````

#### 目录结构转为数组结构

````php
var_dump(LiFileOperator::dirToArray(dirname(__DIR__)));
````

#### 获取一个临时文件名

````php
var_dump(LiFileOperator::getTmpFileName());
````

#### 文件写入临时文件

````php
var_dump(LiFileOperator::writeToTmpFile(111222));
````

#### 列出文件的时间并作用到回调函数

````php
LiFileOperator::listFilesByTime(dirname(__DIR__), LiFileOperator::CTIME, function ($fileTime, $filename) {
    var_dump($fileTime, $filename);
});
````

#### 列出文件的时间

````php
$listFiles = LiFileOperator::listFilesByTime(dirname(__DIR__), LiFileOperator::CTIME);
var_dump($listFiles);
````
