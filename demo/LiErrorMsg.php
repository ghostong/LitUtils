<?php

require(dirname(__DIR__) . '/vendor/autoload.php');

class BaseClass
{
    use \Lit\Utils\LiErrMsg;

    public function test() {
        $this->setCodeMsg(1, "测试错误");
        $this->setCode(1);
        $this->setMsg("测试错误");
    }

}

$baseClass = new BaseClass();
$baseClass->test();
var_dump($baseClass->getCodeMsg());
var_dump($baseClass->getCode());
var_dump($baseClass->getMsg());