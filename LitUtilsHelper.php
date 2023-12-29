<?php

if (!function_exists('liHttpGet')) {
    function liHttpGet($url) {
        $httpGet = new \Lit\Utils\LiHttp();
        $httpGet->get($url)->send();
        return $httpGet;
    }
}

if (!function_exists('liHttpPost')) {
    function liHttpPost($url, $params = []) {
        $httpPost = new \Lit\Utils\LiHttp();
        $httpPost->post($url)->setParam($params)->send();
        return $httpPost;
    }
}

if (!function_exists('liHttpPostJson')) {
    function liHttpPostJson($url, $json) {
        $httpPost = new \Lit\Utils\LiHttp();
        $httpPost->postJson($url, $json)->send();
        return $httpPost;
    }
}

if (!function_exists('liHttpDownload')) {
    function liHttpDownload($url, $savePath) {
        $httpPost = new \Lit\Utils\LiHttp();;
        $httpPost->get($url)->setSavePath($savePath)->download(true);
        return $httpPost;
    }
}

if (!function_exists('liDate')) {
    function liDate() {
        return date("Y-m-d");
    }
}

if (!function_exists('liTime')) {
    function liTime() {
        return date("H:i:s");
    }
}

if (!function_exists('liDatetime')) {
    function liDatetime() {
        return date("Y-m-d H:i:s");
    }
}

if (!function_exists('liEcho')) {
    function liEcho(...$logs) {
        call_user_func_array(['Lit\Utils\LiLogs', 'echoSsv'], $logs);
    }
}