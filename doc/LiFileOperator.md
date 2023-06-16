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