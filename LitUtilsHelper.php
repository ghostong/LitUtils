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