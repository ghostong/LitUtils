<?php

require(dirname(__DIR__) . '/vendor/autoload.php');

################################

/**
 * 数据映射
 * @property $a
 * @property $b
 * @property $c
 * @property $d
 * @deprecated 此包已经不在维护, 新版本已经合并入 lit/parameter v2 版本
 * 注意: v2版本不前兼容
 * github https://github.com/ghostong/LitParameter
 * packagist https://packagist.org/packages/lit/parameter
 * composer require lit/parameter
 */
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
var_dump($newMapper->getInsert());
var_dump($newMapper->getUpdate());

//通过参数实例化
$newMapper = new TestMapper(["a" => 10, "b" => "15"]);
var_dump($newMapper->getInsert());
var_dump($newMapper->getUpdate());

var_dump($newMapper->b);


