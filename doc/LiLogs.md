### 简单日志

````php
use  \Lit\Utils\LiLogs;
````

#### 1. 输出CSV 格式日志

````php
\Lit\Utils\LiLogs::echoCsv(1, 2, 3, 4, 5, 6, 7, 8, 9);
````

#### 2. 输出SSV(空格分隔值) 格式日志

````php
\Lit\Utils\LiLogs::echoSsv('a', 'b', 'c', 'd');
````

#### 3. 输出JSON 格式日志

````php
\Lit\Utils\LiLogs::echoJson(['A' => 'a1', 'B' => 'b2', 'C' => 'c3']);
````

#### 4. 贮存日志

````php
\Lit\Utils\LiLogs::stage(['A' => 'a1', 'B' => 'a2', 'C' => 'a3']);
\Lit\Utils\LiLogs::stage(['A' => 'b1', 'B' => 'b2', 'C' => 'b3']);
\Lit\Utils\LiLogs::stage(['A' => 'c1', 'B' => 'c2', 'C' => 'c3']);
````

#### 5. 获取所有贮存日志

````php
var_dump ( \Lit\Utils\LiLogs::getStage() );
````

#### 6. 清空贮存的日志

````php
\Lit\Utils\LiLogs::cleanStage();
````

#### 7. 贮存日志写入到文件

\Lit\Utils\LiLogs::toFile("./aaa/aaa.log",['A' => 'd1', 'B' => 'd2', 'C' => 'd3']);

````
