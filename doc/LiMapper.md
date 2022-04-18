### 数据映射

#### 1. 基础类(数据模型)

````php
class TestMapper extends \Lit\Utils\LiMapper
{
    protected $a = 1;
    protected $b = 2;
    protected $c = 3;
    protected $d = 3;
}
````

#### 2.通过属性实例化

````php
$newMapper = new TestMapper();
$newMapper->a = 30;
$newMapper->d = 50;

var_dump($newMapper->getUpdate()); //获取修改数据
//array(2) {
//  ["a"]=>
//  int(30)
//  ["d"]=>
//  int(50)
//}

var_dump($newMapper->getInsert()); //获取写入数据
//array(4) {
//  ["a"]=>
//  int(30)
//  ["b"]=>
//  int(2)
//  ["c"]=>
//  int(3)
//  ["d"]=>
//  int(50)
//}
````

#### 3.通过参数实例化

````php
$newMapper = new TestMapper(["a" => 10, "b" => "15"]);
var_dump($newMapper->getUpdate()); //获取修改数据
//array(2) {
//  ["a"]=>
//  int(10)
//  ["b"]=>
//  string(2) "15"
//}

var_dump($newMapper->getInsert()); //获取写入数据
//array(4) {
//  ["a"]=>
//  int(10)
//  ["b"]=>
//  string(2) "15"
//  ["c"]=>
//  int(3)
//  ["d"]=>
//  int(3)
//}
````
