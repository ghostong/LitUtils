### 查询映射器

#### 1. 基础类(查询模型)

````php
use  \Lit\Utils\LiSelector;
````

#### 2. 构建查询器

````php
$liSelector = new TestSelector();
$liSelector->book_id->notEqual(2);
$liSelector->book_name->equal("str");
//$liSelector->status->lessThan(20);
//$liSelector->status->greaterEqual(0);
//$liSelector->age->between(10, 20);
//$liSelector->age->in(["1", "2", "3"]);

var_dump($liSelector->getCondition()); //获取构建条件
//array(2) {
//  [0]=>
//  array(3) {
//    [0]=>
//    string(7) "book_id"
//    [1]=>
//    string(2) "!="
//    [2]=>
//    int(2)
//  }
//  [1]=>
//  array(3) {
//    [0]=>
//    string(9) "book_name"
//    [1]=>
//    string(1) "="
//    [2]=>
//    string(3) "str"
//  }
//}
var_dump($liSelector->getSql()); //获取构建条件生成的SQL
//array(2) {
//  [0]=>
//  string(16) "`book_id` != "2""
//  [1]=>
//  string(19) "`book_name` = "str""
//}
````

#### 3. 通过数组构建查询器

````php
try {
    $mySelector = new TestSelector([
        ["book_id", ">", 1],
        ["book_name", "=", "哈哈"]
    ]);
    
    var_dump($mySelector->getCondition());
//    array(2) {
//      [0]=>
//      array(3) {
//        [0]=>
//        string(7) "book_id"
//        [1]=>
//        string(1) ">"
//        [2]=>
//        int(1)
//      }
//      [1]=>
//      array(3) {
//        [0]=>
//        string(9) "book_name"
//        [1]=>
//        string(1) "="
//        [2]=>
//        string(6) "哈哈"
//      }
//    }
    var_dump($mySelector->getSql());
//    array(2) {
//      [0]=>
//      string(15) "`book_id` > "1""
//      [1]=>
//      string(22) "`book_name` = "哈哈""
//    }
} catch (\Exception $exception) {
    var_dump($exception);
}
````
