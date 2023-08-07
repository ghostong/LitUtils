### 位运算实现开关

#### 1. 初始化开关

````php
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
````

#### 2.所有位全开的状态

````php
$currBit = NoticeSwitch::getFullBit();
var_dump(NoticeSwitch::toBinStr($currBit));
//string(5) "11111"
````

#### 3.关闭某个位开关

````php
$currBit = NoticeSwitch::off($currBit, NoticeSwitch::WEATHER);
$currBit = NoticeSwitch::off($currBit, NoticeSwitch::SHOPPING);
$currBit = NoticeSwitch::off($currBit, NoticeSwitch::STRANGER);
var_dump(NoticeSwitch::toBinStr($currBit));
//string(5) "10001"
````

#### 4.打开某个位开关

````php
$currBit = NoticeSwitch::on($currBit, NoticeSwitch::SHOPPING);
var_dump(NoticeSwitch::toBinStr($currBit));
//string(5) "10101"
````

#### 5.某个位是否开

````php
$isOn = NoticeSwitch::isOn($currBit, NoticeSwitch::SHOPPING);
var_dump($isOn);
//bool(true)
````

#### 6.某个位是否关

````php
$isOff = NoticeSwitch::isOff($currBit, NoticeSwitch::WEATHER);
var_dump($isOff);
//bool(true)
````

#### 7.获取某位为开时, 所有可能的值

````php
var_dump(NoticeSwitch::getBitAllOn(NoticeSwitch::WEATHER));
//array(16) {
//  [0]=>
//  int(8)
//  [1]=>
//  int(9)
//  ...
//}
````