<?php

require(dirname(__DIR__) . '/vendor/autoload.php');

/**
 * @value("PASS","通过")
 * @value("REFUSE","拒绝%s")
 * @value("WAIT","待审核")
 */
class testConst extends \Lit\Utils\LiConst
{
    const PASS = 'aaa'; // 通过
    const REFUSE = 'bbb'; // 拒绝
    const WAIT = 'ccc'; // 待审核
}


var_dump(testConst::toArray());
var_dump(testConst::getValues());
var_dump(testConst::getComment('ccc'));
var_dump(testConst::constToValue('REFUSE'));
var_dump(testConst::valueToConst('ccc'));
var_dump(testConst::getComment(testConst::REFUSE, ['文章']));
var_dump(testConst::getComment(testConst::WAIT));