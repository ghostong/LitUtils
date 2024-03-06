<?php


namespace Lit\Utils;

trait LiErrMsg
{
    protected static $code = 0;
    protected static $msg = "";

    /**
     * 获取错误码
     * @date 2022/2/4
     * @return int
     * @author litong
     */
    public static function getCode() {
        return self::$code;
    }

    /**
     * 设置错误码
     * @date 2022/2/4
     * @param int $code
     * @author litong
     */
    protected static function setCode($code) {
        self::$code = $code;
    }

    /**
     * 获取错误信息
     * @date 2022/2/4
     * @return string
     * @author litong
     */
    public static function getMsg() {
        return self::$msg;
    }

    /**
     * 设置错误信息
     * @date 2022/2/4
     * @param string $msg
     * @author litong
     */
    protected static function setMsg($msg) {
        self::$msg = $msg;
    }

    /**
     * 获取错误码和错误信息
     * @date 2022/2/4
     * @return array
     * @author litong
     */
    public static function getCodeMsg() {
        return ['code' => self::getCode(), 'msg' => self::getMsg()];
    }

    /**
     * 设置错误信息
     * @date 2022/2/4
     * @param int $code
     * @param string $msg
     * @author litong
     */
    protected static function setCodeMsg($code, $msg) {
        self::setCode($code);
        self::setMsg($msg);
    }

    /**
     * 设置错误信息
     * @date 2024/3/6
     * @param array $codeMsg
     * @author litong
     */
    protected static function setCodeMsgByArray($codeMsg) {
        self::setCode($codeMsg['code']);
        self::setMsg($codeMsg['msg']);
    }

}