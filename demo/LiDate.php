<?php

require(dirname(__DIR__) . '/vendor/autoload.php');

################################

use  \Lit\Utils\LiDate;

#返回当前时间以秒为单位的微秒数
var_dump(LiDate::microTime());

#回当前时间以秒为单位的毫秒数
var_dump(LiDate::milliTime());

#返回中文格式化的时间
var_dump(LiDate::dateFormat('1494475359'));

#返回下个月是几月
var_dump(LiDate::nextMonth('2015-2-28'));

#返回上个月是几月
var_dump(LiDate::lastMonth('2015-01-01'));

#返回今天还剩多少秒
var_dump(LiDate::todayRemainTime());