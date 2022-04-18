<?php

require(dirname(__DIR__) . '/vendor/autoload.php');

################################

use  \Lit\Utils\LiDate;

//返回当前时间以秒为单位的微秒数
var_dump(LiDate::microTime());

//回当前时间以秒为单位的毫秒数
var_dump(LiDate::milliTime());

//返回中文格式化的时间
var_dump(LiDate::dateFormat(time() - mt_rand(1, 9999)));

//返回指定时间, 下个月是几月
var_dump(LiDate::nextMonth('2015-2-28'));

//返回指定日期时间, 第二天的日期
var_dump(LiDate::nextDay("2023-02-28", "Y-m-d"));

//返回指定时间, 下一个指定时间
var_dump(LiDate::nextTime("10:33:45", "Y-m-d H:i:s"));

//返回上个月是几月
var_dump(LiDate::lastMonth('2015-01-01'));

//返回今天还剩多少秒
var_dump(LiDate::todayRemainTime());