<?php

namespace Lit\Utils;

/**
 * liSundry: PHP 杂项补充部分
 * @author  litong
 * @since   1.0
 **/
class LiSundry
{

    /**
     * RemoteAddr
     * 获取用户来源IP
     * @access public
     * @return string
     * @since  1.0
     */
    public static function getRemoteAddr() {
        static $ip = NULL;
        if ($ip !== NULL) {
            return $ip;
        }
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos) {
                unset($arr[$pos]);
            }
            $ip = trim($arr[0]);
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $long = sprintf("%u", ip2long($ip));  // IP地址合法验证
        $ip = $long ? $ip : '0.0.0.0';
        return $ip;
    }

    /**
     * sendHttpStatus
     * 发送http状态码
     * @access public
     * @param int $code Http状态码
     * @since  1.0
     **/
    public static function sendHttpStatus($code) {
        static $status = array(
            100 => 'Continue', 101 => 'Switching Protocols',
            200 => 'OK', 201 => 'Created', 202 => 'Accepted', 203 => 'Non-Authoritative Information', 204 => 'No Content', 205 => 'Reset Content', 206 => 'Partial Content',
            300 => 'Multiple Choices', 301 => 'Moved Permanently', 302 => 'Moved Temporarily ', 303 => 'See Other', 304 => 'Not Modified', 305 => 'Use Proxy', 306 => 'Switch Proxy', 307 => 'Temporary Redirect',
            400 => 'Bad Request', 401 => 'Unauthorized', 402 => 'Payment Required', 403 => 'Forbidden', 404 => 'Not Found', 405 => 'Method Not Allowed', 406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required', 408 => 'Request Timeout', 409 => 'Conflict', 410 => 'Gone', 411 => 'Length Required', 412 => 'Precondition Failed',
            413 => 'Request Entity Too Large', 414 => 'Request-URI Too Long', 415 => 'Unsupported Media Type', 416 => 'Requested Range Not Satisfiable', 417 => 'Expectation Failed',
            500 => 'Internal Server Error', 501 => 'Not Implemented', 502 => 'Bad Gateway', 503 => 'Service Unavailable', 504 => 'Gateway Timeout', 505 => 'HTTP Version Not Supported', 509 => 'Bandwidth Limit Exceeded'
        );
        if (isset($status[$code])) {
            header('HTTP/1.1 ' . $code . ' ' . $status[$code]);
            header('Status:' . $code . ' ' . $status[$code]);
        }
    }

    /**
     * getWeight
     * 根据权重随机返回被选数据
     * @access public
     * @param array $wd Http状态码
     * @return mixed
     * @since  1.0
     */
    public static function getWeight($wd) {
        $temp = array();
        $weight = 0;
        foreach ($wd as $val) {
            $w = $val['w'];
            $weight += $w;
            for ($i = 0; $i < $w; $i++) {
                $temp[] = $val['v'];
            }
        }
        $r = mt_rand(0, $weight - 1);
        shuffle($temp);
        return $temp[$r];
    }

    /**
     * isLocalIp
     * 判断是否私网IP
     * @access public
     * @param string $ip 要判断的IP
     * @return boolean
     * @since  1.0
     */
    public static function isLocalIp($ip) {
        return self::isPrivateIpV4($ip);
    }

    /**
     * isIdNumber18
     * 判断是否18位身份证号
     * @access public
     * @param string $idNum 要判断的身份证号
     * @param string $gender 性别 0 女 , 1 男
     * @return boolean
     * @since  dev
     */
    public static function isIdNumber($idNum, $gender = Null) {
        $weight = array("7", "9", "10", "5", "8", "4", "2", "1", "6", "3", "7", "9", "10", "5", "8", "4", "2");
        $checkCode = array("1", "0", "X", "9", "8", "7", "6", "5", "4", "3", "2");
        $num = substr($idNum, 0, 17);
        $bd = substr($idNum, 6, 8); //生日
        $gc = substr($idNum, 14, 3); //顺序码
        $cc = substr($idNum, -1); //校验码
        if (strlen($num) != 17 || !is_numeric($num) || !in_array($cc, $checkCode)) { //判断身份证规则
            return false;
        }
        if ($gender !== Null && $gc % 2 != $gender) { //判断性别
            return false;
        }
        //判断生日
        if (date('Ymd', strtotime($bd)) != $bd) {
            return false;
        }
        $MaxAge = 130;
        $by = substr($bd, 0, 4);
        $endYear = date('Y');
        $startYear = $endYear - $MaxAge;
        if ($startYear > $by || $by > $endYear) {
            return false;
        }
        //判断校验码
        $cNum = 0;
        for ($i = 0; $i < 17; $i++) {
            $cNum += $num[$i] * $weight[$i];
        }
        if ($checkCode[$cNum % 11] != strtoupper($cc)) {
            return false;
        }
        return true;
    }

    /**
     * 是否IP
     * @param string $ip ip地址
     * @return bool
     */
    public static function isIp($ip) {
        return self::isIpV4($ip) || self::isIpV6($ip);
    }

    /**
     * 是否IPV4
     * @param string $ip ip地址
     * @return bool
     */
    public static function isIpV4($ip) {
        return !is_null(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_NULL_ON_FAILURE));
    }

    /**
     * 是否IPV6
     * @param string $ip ip地址
     * @return bool
     */
    public static function isIpV6($ip) {
        return !is_null(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 | FILTER_NULL_ON_FAILURE));
    }

    /**
     * 是否内网IP
     * @param string $ip ip地址
     * @return bool
     */
    public static function isPrivateIp($ip) {
        return self::isPrivateIpV4($ip) || self::isPrivateIpV6($ip);
    }

    /**
     * 是否内网IPV4
     * @param string $ip ip地址
     * @return bool
     */
    public static function isPrivateIpV4($ip) {
        return self::isIpV4($ip) && is_null(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE | FILTER_NULL_ON_FAILURE));
    }

    /**
     * 是否内网IPV6
     * @param string $ip ip地址
     * @return bool
     */
    public static function isPrivateIpV6($ip) {
        return self::isIpV6($ip) && is_null(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE | FILTER_NULL_ON_FAILURE));
    }

    /**
     * 是否邮箱
     * @param string $email 邮箱地址
     * @return bool
     */
    public static function isEmail($email) {
        return !is_null(filter_var($email, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE));
    }

    /**
     * 下载 header
     * @param string $fileName 文件名称
     * @param string $contentType 下载类型
     * @param string $charset 字符集
     * @param bool $send 是否自动发送
     * @doc 常用 Content-Type
     *      逗号分隔值: text/comma-separated-values
     *      ZIP压缩包: application/zip
     * @return array
     */
    public static function downLoadHeader($fileName, $contentType, $charset = "UTF-8", $send = false) {
        $headers[] = "Pragma: no-cache";
        $headers[] = "Expires: 0";
        $headers[] = "Cache-Control: no-store, no-cache, must-revalidate,  pre-check=0, post-check=0, max-age=0";
        $headers[] = "Content-Transfer-Encoding: binary";
        $headers[] = "Content-Type: {$contentType}; charset={$charset}";
        $headers[] = "Content-Disposition: attachment; filename={$fileName}";
        $headers[] = "Access-Control-Expose-Headers: Download-Filename";
        $fileName = rawurlencode($fileName);
        $headers[] = "Download-Filename: {$fileName}";
        if ($send) {
            foreach ($headers as $header) {
                header($header);
            }
        }
        return $headers;
    }


    /**
     * 获取所有headers
     * @return array
     */
    public static function getAllHeaders() {
        if (function_exists('getallheaders')) {
            return getallheaders();
        } else {
            $headers = array();
            $copy_server = array(
                'CONTENT_TYPE' => 'Content-Type',
                'CONTENT_LENGTH' => 'Content-Length',
                'CONTENT_MD5' => 'Content-Md5',
            );
            foreach ($_SERVER as $key => $value) {
                if (substr($key, 0, 5) === 'HTTP_') {
                    $key = substr($key, 5);
                    if (!isset($copy_server[$key]) || !isset($_SERVER[$key])) {
                        $key = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', $key))));
                        $headers[$key] = $value;
                    }
                } elseif (isset($copy_server[$key])) {
                    $headers[$copy_server[$key]] = $value;
                }
            }
            if (!isset($headers['Authorization'])) {
                if (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
                    $headers['Authorization'] = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
                } elseif (isset($_SERVER['PHP_AUTH_USER'])) {
                    $basic_pass = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';
                    $headers['Authorization'] = 'Basic ' . base64_encode($_SERVER['PHP_AUTH_USER'] . ':' . $basic_pass);
                } elseif (isset($_SERVER['PHP_AUTH_DIGEST'])) {
                    $headers['Authorization'] = $_SERVER['PHP_AUTH_DIGEST'];
                }
            }
            return $headers;
        }
    }


    /**
     * 随机一个颜色
     * @return string
     */
    public static function randomColor() {
        $r = dechex(rand(0, 255));
        $g = dechex(rand(0, 255));
        $b = dechex(rand(0, 255));
        if (strlen($r) == 1) $r = '0' . $r;
        if (strlen($g) == 1) $g = '0' . $g;
        if (strlen($b) == 1) $b = '0' . $b;
        return '#' . $r . $g . $b;
    }

}
