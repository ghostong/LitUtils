### 日期时间部分

````php
use  \Lit\Utils\LiDate;
````

#### 1. 返回当前时间以秒为单位的微秒数

````php
var_dump ( LiDate::microTime() );
//string(17) "1623396847.630771"
````

#### 2. 回当前时间以秒为单位的毫秒数

````php
var_dump ( LiDate::milliTime() );
//string(14) "1623396847.631"
````

#### 3. 返回中文格式化的时间

````php
var_dump ( LiDate::dateFormat(time()-mt_rand(1,9999)) );
//string(10) "1分钟前"
````

#### 4. 返回指定时间, 下个月是几月

````php
var_dump ( LiDate::nextMonth('2015-2-28') );
//string(7) "2015-03"
````

#### 5. 返回指定时间, 第二天的日期

````php
var_dump(LiDate::nextDay("2023-02-28", "Y-m-d"));
//string(10) "2023-03-01"
````

#### 6. 返回指定时间, 下一个指定时间

````php
var_dump(LiDate::nextTime("10:33:45", "Y-m-d H:i:s"));
````

#### 7. 返回上个月是几月

````php
var_dump ( LiDate::lastMonth('2015-01-01') );
//string(7) "2014-12"
````

#### 8. 返回今天还剩多少秒

````php
var_dump ( LiDate::todayRemainTime() );
//int(58922)
````


#### 9. 返回本月的第一天
````php
var_dump(LiDate::monthFirstDay("2022-01-07 15:20:30"));
//string(10) "2022-01-01"
````

#### 10. 返回本月的最后一天
````php
var_dump(LiDate::monthLastDay("2020-02-07 14:15:16"));
//string(10) "2020-02-29"
````
