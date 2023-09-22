### 简单数据映射

#### 1. 初始化mapper

````php
class TestEasyMapper extends \Lit\Utils\LiEasyMapper
{

    public $a = null;

    protected $b = 2; //不可声明 protected

    private $c = null; //不可声明 private

    public $d = null;

    public $e = null;

}
````

#### 2. mapper 赋值

````php
//批量赋值
$mapper = new TestEasyMapper(["a" => 1, "b" => 2, "c" => 3]);

//单个赋值
$mapper->d = 4;
````

#### 4. 获取 mapper 数据

````php
//获取为数组
var_dump($mapper->toArray());
//array(3) {
//  ["a"]=>
//  int(1)
//  ["d"]=>
//  int(4)
//  ["e"]=>
//  NULL
//}

//获取单个值
var_dump($mapper->d);
//int(4)
````