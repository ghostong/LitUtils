<?php

require(dirname(__DIR__) . '/vendor/autoload.php');

################################

use  \Lit\Utils\LiDebug;

function a() {
    LiDebug::anchor("aaa");
    return 1 + 1;
}

LiDebug::anchor("xxx");
a();
LiDebug::anchor("xxx");
var_dump(LiDebug::getAll());
var_dump(LiDebug::getFormat());
