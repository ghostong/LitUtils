<?php


namespace Lit\Utils;

trait LiErrMsg
{
    protected $code = 0;
    protected $msg = "";

    /**
     * 获取错误码
     * @date 2022/2/4
     * @return int
     * @author litong
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * 设置错误码
     * @date 2022/2/4
     * @param int $code
     * @author litong
     */
    protected function setCode($code) {
        $this->code = $code;
    }

    /**
     * 获取错误信息
     * @date 2022/2/4
     * @return string
     * @author litong
     */
    public function getMsg() {
        return $this->msg;
    }

    /**
     * 设置错误信息
     * @date 2022/2/4
     * @param string $msg
     * @author litong
     */
    protected function setMsg($msg) {
        $this->msg = $msg;
    }

    /**
     * 获取错误码和错误信息
     * @date 2022/2/4
     * @return array
     * @author litong
     */
    public function getCodeMsg() {
        return ['code' => $this->getCode(), 'msg' => $this->getMsg()];
    }

    /**
     * 设置错误信息
     * @date 2022/2/4
     * @param int $code
     * @param string $msg
     * @author litong
     */
    protected function setCodeMsg($code, $msg) {
        $this->setCode($code);
        $this->setMsg($msg);
    }

}