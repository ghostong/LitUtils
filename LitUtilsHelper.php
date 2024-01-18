<?php

if (!function_exists('liHttpGet')) {
    /**
     * 快速HttpGet请求
     * @date 2024/1/4
     * @param $url
     * @return \Lit\Utils\LiHttp
     * @author litong
     */
    function liHttpGet($url) {
        $httpGet = new \Lit\Utils\LiHttp();
        $httpGet->get($url)->send();
        return $httpGet;
    }
}


if (!function_exists('liHttpPost')) {
    /**
     * 快速HttpPost
     * @date 2024/1/4
     * @param $url
     * @param array $params
     * @return \Lit\Utils\LiHttp
     * @author litong
     */
    function liHttpPost($url, $params = []) {
        $httpPost = new \Lit\Utils\LiHttp();
        $httpPost->post($url)->setParam($params)->send();
        return $httpPost;
    }
}


if (!function_exists('liHttpPostJson')) {
    /**
     * 快速PostJson
     * @date 2024/1/4
     * @param $url
     * @param $json
     * @return \Lit\Utils\LiHttp
     * @author litong
     */
    function liHttpPostJson($url, $json) {
        $httpPost = new \Lit\Utils\LiHttp();
        $httpPost->postJson($url, $json)->send();
        return $httpPost;
    }
}

if (!function_exists('liHttpDownload')) {
    /**
     * 快速Http下载
     * @date 2024/1/4
     * @param $url
     * @param $savePath
     * @return \Lit\Utils\LiHttp
     * @author litong
     */
    function liHttpDownload($url, $savePath) {
        $httpPost = new \Lit\Utils\LiHttp();;
        $httpPost->get($url)->setSavePath($savePath)->download(true);
        return $httpPost;
    }
}

if (!function_exists('liDate')) {
    /**
     * 快速日期
     * @date 2024/1/4
     * @param null|string|int $ts
     * @return string
     * @author litong
     */
    function liDate($ts = null) {
        return date("Y-m-d", $ts ?: time());
    }
}

if (!function_exists('liTime')) {
    /**
     * 快速时间
     * @date 2024/1/4
     * @param null|string|int $ts
     * @return string
     * @author litong
     */
    function liTime($ts = null) {
        return date("H:i:s", $ts ?: time());
    }
}

if (!function_exists('liDatetime')) {
    /**
     * 快速时间日期
     * @date 2024/1/4
     * @param null|string|int $ts
     * @return string
     * @author litong
     */
    function liDatetime($ts = null) {
        return date("Y-m-d H:i:s", $ts ?: time());
    }
}

if (!function_exists('liEcho')) {
    /**
     * 快速输出格式化字符串
     * @date 2024/1/4
     * @return void
     * @author litong
     */
    function liEcho(...$logs) {
        call_user_func_array(['\Lit\Utils\LiLogs', 'echoSsv'], $logs);
    }
}

if (!function_exists('liDump')) {
    /**
     * 快速Debug打印
     * @date 2024/1/4
     * @return void
     * @author litong
     */
    function liDump(...$logs) {
        $trace = current(debug_backtrace(false, 1));
        if ($trace) {
            echo "\n---------- {$trace['file']}:{$trace['line']} start ----------\n";
            var_dump($logs);
            echo "\n---------- {$trace['file']}:{$trace['line']} end ----------\n\n";
        }
    }
}


if (!function_exists('liDumpException')) {
    /**
     * 快速 打印 Exception
     * @date 2024/1/4
     * @param Exception $exception
     * @return void
     * @author litong
     */
    function liDumpException($exception) {
        echo '[ File: ', $exception->getFile(), ':', $exception->getLine(), " ]\n";
        echo '[ Code: ', $exception->getCode(), ', Message: ', $exception->getMessage(), " ]\n";
        echo $exception->getTraceAsString(), "\n";
        echo "-------------------- [", liDatetime(), "] --------------------\n";
    }
}