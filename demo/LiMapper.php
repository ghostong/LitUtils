<?php

require(dirname(__DIR__) . '/vendor/autoload.php');

################################

#数据映射
class TestMapper extends \Lit\Utils\LiMapper
{
    protected $a = 1;
    protected $b = 2;
    protected $c = 3;
    protected $d = 3;
}

//通过属性实例化
$newMapper = new TestMapper();
$newMapper->a = 30;
$newMapper->d = 50;
var_dump($newMapper->update());
var_dump($newMapper->insert());

//通过参数实例化
try {
    $newMapper = new TestMapper(["a" => 10, "b" => "15"]);
} catch (Exception $e) {
}
var_dump($newMapper->update());
var_dump($newMapper->insert());


