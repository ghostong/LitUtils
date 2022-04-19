### 逻辑运算

    增强型逻辑运算函数

````php
use  \Lit\Utils\LiStructures;
````

#### 1. 选择偶数形参(参数下标从0开始) 强制类型转换bool值 的下一个形参的值

````php
var_dump(LiStructures::trueNext(false, true, false, 2, true, 1));
//int(1)
````