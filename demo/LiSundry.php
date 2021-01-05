<?php

require(dirname(__DIR__) . '/vendor/autoload.php');

################################

use  \Lit\Utils\LiSundry;

#获取用户来源IP
var_dump(LiSundry::getRemoteAddr());

#发送http状态码
LiSundry::sendHttpStatus(404);

#根据权重随机返回备选数据
$wd = array(
    array('w' => 60, 'v' => '我是60%概率'),
    array('w' => 35, 'v' => '我是35%概率'),
    array('w' => 5, 'v' => '我是5%概率'),
);
var_dump(LiSundry::getWeight($wd));

#判断是否私网IP
var_dump(LiSundry::isLocalIp('10.25.11.58'));

#判断是否18位身份证号
var_dump(LiSundry::isIdNumber('130602199001011111', 1));

