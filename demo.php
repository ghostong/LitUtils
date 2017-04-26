<?php

require(__DIR__.'/vendor/autoload.php');

use  \lit\litool\liarray;

#测试调用
var_dump (liarray::init());

#通过正则表达式匹配一维数组的值,返回正则表达式匹配部分
var_dump ( liarray::RegexArray (['aa','bb','cc','ab','ac'],'/^a/') );

################################

use  \lit\litool\listring;

#测试调用
var_dump (listring::init());

################################

use  \lit\litool\lidate;

#测试调用
var_dump (lidate::init());
