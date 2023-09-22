<?php

require(dirname(__DIR__) . '/vendor/autoload.php');

class TestEasyMapper extends \Lit\Utils\LiEasyMapper
{

    public $a = null;

    protected $b = 2; //不可声明 protected

    private $c = null; //不可声明 private

    public $d = null;

    public $e = null;

}

$mapper = new TestEasyMapper(["a" => 1, "b" => 2, "c" => 3]);
$mapper->d = 4;
var_dump($mapper->a);
var_dump($mapper->toArray());