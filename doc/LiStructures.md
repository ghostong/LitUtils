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

#### 4. 返回下个月是几月

````php
var_dump ( LiDate::nextMonth('2015-2-28') );
//string(7) "2015-03"
````

#### 5. 返回上个月是几月

````php
var_dump ( LiDate::lastMonth('2015-01-01') );
//string(7) "2014-12"
````

#### 6. 返回今天还剩多少秒

````php
var_dump ( LiDate::todayRemainTime() );
//int(58922)
````