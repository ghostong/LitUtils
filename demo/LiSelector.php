<?php

require(dirname(__DIR__) . '/vendor/autoload.php');

use  \Lit\Utils\LiSelector;

/**
 * 查询构造器
 * @property TestSelector $book_id
 * @property TestSelector $book_name
 * @property TestSelector $status
 * @property TestSelector $age
 */
class TestSelector extends LiSelector
{
    protected $book_id;
    protected $book_name;
    protected $status;
    protected $age;

}

//构建查询器
$liSelector = new TestSelector();
$liSelector->book_id->isNull();
$liSelector->book_id->notEqual(2);
$liSelector->book_name->equal(null);
$liSelector->book_name->like("str");
//$liSelector->status->lessThan(20);
//$liSelector->status->greaterEqual(0);
//$liSelector->age->between(10, 20);
//$liSelector->age->in(["1", "2", "3"]);
var_dump($liSelector->getCondition('alias'));
var_dump($liSelector->getSql());

//通过数组构建查询器
try {
    $mySelector = new TestSelector([
        ["book_id", ">", 1],
        ["book_name", "=", "哈哈"]
    ]);
    var_dump($mySelector->getCondition());
    var_dump($mySelector->getSql());
} catch (\Exception $exception) {
    var_dump($exception);
}


