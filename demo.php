<?php

require(__DIR__.'/vendor/autoload.php');

use  \lit\litool\liarray;

//通过正则表达式匹配一维数组的值,返回正则表达式匹配部分
var_dump ( liarray::RegexArray (['aa','bb','cc','ab','ac'],'/^a/') );

