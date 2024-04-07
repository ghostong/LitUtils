<?php

require(dirname(__DIR__) . '/vendor/autoload.php');

/**
 * @value("PASS","通过")
 * @value("REFUSE","拒绝%s")
 * @value("WAIT","待审核")
 */
class testConst extends \Lit\Utils\LiConst
{
    const PASS = 1; // 通过
    const REFUSE = 2; // 拒绝
    const WAIT = 3; // 待审核
}


var_dump(testConst::toArray());
var_dump(testConst::getValues());
var_dump(testConst::getComment(1));
var_dump(testConst::getComment(testConst::REFUSE, ['文章']));
var_dump(testConst::getComment(testConst::WAIT));