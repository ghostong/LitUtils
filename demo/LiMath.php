<?php

require(dirname(__DIR__) . '/vendor/autoload.php');

################################

use  \Lit\Utils\LiMath;

//10进制转62进制
var_dump(LiMath::base10to62(40000));

//62进制转10进制
var_dump(LiMath::base62to10('ACG97'));

//数字是否在两个数中间(包含边界)
var_dump(LiMath::between(6, 1, 6));