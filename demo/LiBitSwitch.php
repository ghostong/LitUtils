<?php
require(dirname(__DIR__) . '/vendor/autoload.php');

/**
 * @value("FRIENDS","好友通知")
 * @value("STRANGER","陌生人通知")
 * @value("SHOPPING","购物通知")
 * @value("WEATHER","天气通知")
 * @value("TRAFFIC","交通通知")
 */
class NoticeSwitch extends \Lit\Utils\LiBitSwitch
{
    const FRIENDS = 2 ** 0;
    const STRANGER = 2 ** 1;
    const SHOPPING = 2 ** 2;
    const WEATHER = 2 ** 3;
    const TRAFFIC = 2 ** 4;
}

//所有开关为开的状态
$currBit = NoticeSwitch::getFullBit();
var_dump(NoticeSwitch::toBinStr($currBit));

//关闭某个位开关
$currBit = NoticeSwitch::off($currBit, NoticeSwitch::WEATHER);
$currBit = NoticeSwitch::off($currBit, NoticeSwitch::SHOPPING);
$currBit = NoticeSwitch::off($currBit, NoticeSwitch::STRANGER);
var_dump(NoticeSwitch::toBinStr($currBit));

//打开某个位开关
$currBit = NoticeSwitch::on($currBit, NoticeSwitch::SHOPPING);
var_dump(NoticeSwitch::toBinStr($currBit));

//某个位是否开
$isOn = NoticeSwitch::isOn($currBit, NoticeSwitch::SHOPPING);
var_dump($isOn);

//某个位是否关
$isOff = NoticeSwitch::isOff($currBit, NoticeSwitch::WEATHER);
var_dump($isOff);

//获取某位为开时, 所有可能的值
var_dump(NoticeSwitch::getBitAllOn(NoticeSwitch::WEATHER));