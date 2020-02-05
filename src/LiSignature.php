<?php

namespace Lit\Litool;

/**
 * liSignature: litool PHP 接口HTTP访问签名验证
 * @author  litong
 * @since   1.0
 **/

class LiSignature {

    //基础参数
    private $checkParam = [
        "AccessKeyId" , // 访问密钥 ID
        "Version" , // 版本
        "SignatureNonce" , //签名唯一随机数, 用于防止网络重放攻击
        "Timestamp" , // 请求的时间戳
    ];

    //用户参数
    private $userParam = [];

    //待签名字符串
    private $signatureString;

    //错误调试
    private $errorCode;
    private $errorString;

    /**
     * buildQuery
     * 构建请求
     * @access public
     * @param  string $key url参数
     * @param  string $val 参数值
     * @since  1.0
     * @return void
     **/
    public function buildQuery ( $key , $val ) {
        $this->userParam[$key] = $val;
    }

    /**
     * getQueryString
     * 获取请求字符串
     * @access public
     * @param  string $HTTPMethod http访问方式固定 GET
     * @param  string $accessKeySecret 访问密钥
     * @since  1.0
     * @return string
     **/
    public function getQueryString( $HTTPMethod, $accessKeySecret ) {
        if ( $this->checkParam() ) {
            $queryString = http_build_query($this->userParam);
            return $queryString."&Signature=".$this->doSignature($HTTPMethod,$accessKeySecret);
        }else{
            return "";
        }
    }

    /**
     * getQueryUrl
     * 获取请求URL
     * @access public
     * @param  string $url 接口地址
     * @param  string $HTTPMethod http访问方式固定 GET
     * @param  string $accessKeySecret 访问密钥
     * @since  1.0
     * @return string
     **/
    public function getQueryUrl( $url, $HTTPMethod, $accessKeySecret ){
        $queryString = $this->getQueryString( $HTTPMethod, $accessKeySecret );
        if ( $queryString ) {
            return $url."?".$queryString;
        }else{
            return "";
        }
    }

    //检查参数
    private function checkParam(){
        foreach ( $this->checkParam as $param ) {
            if ( !isset($this->userParam[$param]) ) {
                $this->setError (9100, "参数.".$param." 不能为空" );
                return false;
            }
        }
        return true;
    }

    //加密
    private function doSignature( $HTTPMethod, $accessKeySecret, $userParam = []){
        if (empty($userParam)) {
            $userParam = $this->userParam;
        }
        ksort($userParam );
        $queryString = http_build_query( $userParam );
        $data = $HTTPMethod."&".urlencode("/")."&".$queryString;
        $this->signatureString = $data;
        $signature = md5( hash_hmac("sha1", $data, $accessKeySecret, true) );
        return $signature;
    }

    /**
     * checkSignature
     * 验证访问有效性
     * @access public
     * @param  string $HTTPMethod  http访问方式固定 GET
     * @param  string $queryString  URL参数部分
     * @param  string $accessKeySecret 访问密钥
     * @since  1.0
     * @return bool
     **/
    public function checkSignature( $HTTPMethod, $queryString, $accessKeySecret, $userNonceFunction = null ){
        parse_str($queryString,$queryArray);
        $signature = $queryArray["Signature"];
        unset($queryArray["Signature"]);
        //算法验证
        $selfSign = $this->doSignature ( $HTTPMethod, $accessKeySecret, $queryArray );
        if( $signature !== $selfSign ) {
            $this->setError (9101, "服务端Signature: {$signature}, 参数Signature: {$selfSign} ; 匹配失败!" );
            return false;
        }
        //验证时间
        if ( ! $this->doTimeCheck ($queryArray["Timestamp"]) ) {
            return false;
        }
        //验证访问唯一性
        if( ! $this->doSignatureNonceCheck( $queryArray["SignatureNonce"], $userNonceFunction ) ){
            return false;
        }
        return true;
    }

    //时间验证算法
    private function doTimeCheck( $queryTime ){
        try{
            if( !is_numeric($queryTime) || strlen($queryTime) != 10 ) {
                $this->setError (9104, "Timestamp 必须为10位时间戳!");
                return false;
            }
            $nowTime = time();
            $m = $nowTime - $queryTime; //慢300秒之内
            if ( $m >= 0 && $m < 300 ){
                return true;
            }
            $s = $queryTime - $nowTime;
            if ( $s >= 0 && $s < 300 ){ //快300秒之内
                return true;
            }
            $this->setError (9102, "服务器时间戳: {$nowTime}, 参数时间戳: {$queryTime}; 时间错误!");
            return false;
        }catch (\Exception $e) {
            $this->setError (9103, $e->getMessage() );
            return false;
        }
    }

    //唯一码验证
    private function doSignatureNonceCheck( $signatureNonce, $userNonceFunction = null ){
        if (strlen($signatureNonce)< 10) {
            $this->setError(9105, "SignatureNonce 长度必须大于等于10位!");
            return false;
        }
        if (!is_null($userNonceFunction)) {
            if ( call_user_func( $userNonceFunction, $signatureNonce ) ) { //用户自定义
                $this->setError(9106, "用户自定义函数 {$userNonceFunction} 返回 true, 代表着此 SignatureNonce 已被使用!");
                return false;
            }
        }
        return true;
    }

    /**
     * getSignatureString
     * 获取待签名字符串 调试用
     * @access public
     * @since  1.0
     * @return string
     **/
    public function getSignatureString(){
        return $this->signatureString;
    }

    //设置错误
    private function setError( $code, $error ){
        $this->errorCode = $code;
        $this->errorString = $error;
    }

    /**
     * getErrorCode
     * 获取错误代码
     * @access public
     * @since  1.0
     * @return int
     **/
    public function getErrorCode(){
        return $this->errorCode;
    }

    /**
     * getErrorString
     * 获取错误提示
     * @access public
     * @since  1.0
     * @return string
     **/
    public function getErrorString(){
        return $this->errorString;
    }

}