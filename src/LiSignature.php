<?php

namespace Lit\Utils;

/**
 * liSignature: litool PHP 接口HTTP访问签名验证
 * @author  litong
 * @since   1.0
 **/
class LiSignature
{

    //基础参数
    private $checkParam = [
        "AccessKeyId", // 访问密钥 ID
        "Version", // 版本
        "SignatureNonce", //签名唯一随机数, 用于防止网络重放攻击
        "Timestamp", // 请求的时间戳
    ];

    //GET参数
    private $httpGetParam = [];

    //POST参数
    private $httpPostParam = [];

    //待签名字符串
    private $signatureString;

    //错误调试
    private $errorCode;
    private $errorString;

    /**
     * addGetParam
     * 构建GET参数
     * @access public
     * @param string $key get参数
     * @param string $val 参数值
     * @return void
     * @since  1.0
     */
    public function addGetParam($key, $val) {
        $this->httpGetParam[$key] = $val;
    }

    /**
     * getGetParam
     * 获取GET参数
     * @access public
     * @return array
     * @since  1.0
     */
    public function getGetParam() {
        return $this->httpGetParam;
    }

    /**
     * addPostParam
     * 构建POST参数
     * @access public
     * @param string $key post参数
     * @param string $val 参数值
     * @return void
     * @since  1.0
     */
    public function addPostParam($key, $val) {
        $this->httpPostParam[$key] = $val;
    }

    /**
     * getPostParam
     * 获取POST参数
     * @access public
     * @return array
     * @since  1.0
     */
    public function getPostParam() {
        return $this->httpPostParam;
    }

    /**
     * getQueryString
     * 获取请求字符串
     * @access public
     * @param string $path url路径
     * @param string $accessKeySecret 访问密钥
     * @return string
     * @since  1.0
     */
    public function getQueryString($path, $accessKeySecret) {
        if ($this->checkParam()) {
            $queryString = http_build_query($this->httpGetParam);
            return $queryString . "&Signature=" . $this->doSignature($path, $accessKeySecret);
        } else {
            return "";
        }
    }

    /**
     * getQueryUrl
     * 获取请求URL
     * @access public
     * @param string $url 接口地址
     * @param string $urlPath url路径
     * @param string $accessKeySecret 访问密钥
     * @return string
     * @since  1.0
     */
    public function getQueryUrl($url, $urlPath, $accessKeySecret) {
        $queryString = $this->getQueryString($urlPath, $accessKeySecret);
        if ($queryString) {
            return $url . $urlPath . "?" . $queryString;
        } else {
            return "";
        }
    }

    //检查参数
    private function checkParam() {
        foreach ($this->checkParam as $param) {
            if (!isset($this->httpGetParam[$param])) {
                $this->setError(9100, "参数 " . $param . " 为必填参数");
                return false;
            }
        }
        return true;
    }

    //加密
    private function doSignature($urlPath, $accessKeySecret, $httpGetParam = [], $httpPostParam = []) {
        if (empty($httpGetParam)) {
            $httpGetParam = $this->httpGetParam;
        }
        if (empty($httpPostParam)) {
            $httpPostParam = $this->httpPostParam;
        }
        if (empty($accessKeySecret)) {
            $this->setError(9107, "对应的 accessKeySecret 不存在");
            return "";
        }
        if (empty($urlPath)) {
            $this->setError(9108, "urlPath 为空");
            return "";
        }
        if ($urlPath[0] != "/") {
            $this->setError(9109, "urlPath 的起始应为 / ");
            return "";
        }
        ksort($httpGetParam);
        $queryString = http_build_query($httpGetParam);
        ksort($httpPostParam);
        $postString = http_build_query($httpPostParam);
        $data = "REQUEST" . "&" . urlencode($urlPath) . "&" . $queryString . "&" . $postString;
        $this->signatureString = $data;
        $signature = md5(hash_hmac("sha1", $data, $accessKeySecret, true));
        return $signature;
    }

    /**
     * checkSignature
     * 验证访问有效性
     * @access public
     * @param string $urlPath url路径
     * @param string $accessKeySecret 访问密钥
     * @param array $get http GET 参数
     * @param array $post http POST 参数
     * @param null $userNonceFunction
     * @return bool
     * @since  1.0
     */
    public function checkSignature($urlPath, $accessKeySecret, $get, $post, $userNonceFunction = null) {
        if (!$this->checkParam()) {
            return false;
        }
        if (!isset($get["Signature"])) {
            $this->setError(9111, "参数 Signature 不能为空");
            return false;
        }
        $signature = $get["Signature"];
        unset($get["Signature"]);
        //算法验证
        $selfSign = $this->doSignature($urlPath, $accessKeySecret, $get, $post);
        if (empty($selfSign)) {
            return false;
        }
        if ($signature !== $selfSign) {
            $this->setError(9101, "服务端 Signature 与参数 Signature 匹配失败!");
            return false;
        }
        //验证时间
        if (!$this->doTimeCheck($get["Timestamp"])) {
            return false;
        }
        //验证访问唯一性
        if (!$this->doSignatureNonceCheck($get["SignatureNonce"], $userNonceFunction)) {
            return false;
        }
        return true;
    }

    //时间验证算法
    private function doTimeCheck($queryTime) {
        try {
            if (!is_numeric($queryTime) || !in_array(strlen($queryTime), [10, 13])) {
                $this->setError(9104, "Timestamp 必须为10位或13位!");
                return false;
            }
            $queryTime = strlen($queryTime) == 13 ? substr($queryTime, 0, 10) : $queryTime;
            $nowTime = time();
            $m = $nowTime - $queryTime; //慢300秒之内
            if ($m >= 0 && $m < 300) {
                return true;
            }
            $s = $queryTime - $nowTime;
            if ($s >= 0 && $s < 300) { //快300秒之内
                return true;
            }
            $this->setError(9102, "服务器时间戳: {$nowTime}, 参数时间戳: {$queryTime}; 时间错误!");
            return false;
        } catch (\Exception $e) {
            $this->setError(9103, $e->getMessage());
            return false;
        }
    }

    //唯一码验证
    private function doSignatureNonceCheck($signatureNonce, $userNonceFunction = null) {
        if (strlen($signatureNonce) < 10) {
            $this->setError(9105, "SignatureNonce 长度必须大于等于10位!");
            return false;
        }
        if (!is_null($userNonceFunction)) {
            if (!function_exists($userNonceFunction)) {
                $this->setError(9110, "用户自定义 Nonce 函数不存在!");
                return false;
            }
            if (call_user_func($userNonceFunction, $signatureNonce)) { //用户自定义
                $this->setError(9106, "此 SignatureNonce 已被使用!");
                return false;
            }
        }
        return true;
    }

    /**
     * getSignatureString
     * 获取待签名字符串 调试用
     * @access public
     * @return string
     * @since  1.0
     */
    public function getSignatureString() {
        return $this->signatureString;
    }

    //设置错误
    private function setError($code, $error) {
        $this->errorCode = $code;
        $this->errorString = $error;
    }

    /**
     * getErrorCode
     * 获取错误代码
     * @access public
     * @return int
     * @since  1.0
     */
    public function getErrorCode() {
        return $this->errorCode;
    }

    /**
     * getErrorString
     * 获取错误提示
     * @access public
     * @return string
     * @since  1.0
     */
    public function getErrorString() {
        return $this->errorString;
    }

}