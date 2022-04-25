<?php

require(dirname(__DIR__) . '/vendor/autoload.php');

class BaseClass
{
    use \Lit\Utils\LiErrMsg;

    public function test() {
        $this->setCode(1);
        $this->setMsg("测试错误 test1");
    }

    public static function test2() {
        self::setCodeMsg(2, "测试错误 test2");
    }

}

$baseClass = new BaseClass();
$baseClass->test();
var_dump($baseClass->getCodeMsg());

$baseClass->test2();
var_dump($baseClass->getCode());
var_dump($baseClass->getMsg());