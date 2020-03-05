<?php

namespace Lit\Utils;

/**
 * liEasyAuth: 简单身份认证
 * 此方法只适用于简单身份认证,不适合高并发,大数据量,高安全性的用户系统
 * @author  litong
 * @since   1.0
 **/

class LiEasyAuth {

    //单例缓存变量
    static private $instance;

    //用户数据库目录,目录必须可写
    private $dataBaseDir = "/opt/phpLiEasyAuth";

    /**
     * LiEasyAuth constructor.
     * @param string $dbDir
     * @throws \Exception
     */
    private function __construct($dbDir = ""){
        if ( is_dir($dbDir) && is_writable($dbDir) ) {
            $this->dataBaseDir = $dbDir;
        }elseif(mkdir($dbDir,744,true)){
            $this->dataBaseDir = $dbDir;
        }else{
            throw new \Exception("Data base dir not exits or not writable!",1);
        }
    }

    /**
     * getInstance
     * 获取对象单例
     * @param string $dbDir
     * @return LiEasyAuth
     * @throws \Exception
     */
    static public function getInstance($dbDir = ""){
         if (!self::$instance instanceof self) {
             self::$instance = new self($dbDir);
         }
         return self::$instance;
    }

    /**
     * addUser
     * 注册一个用户
     * @access public
     * @param  string  $userName 用户名
     * @param  string $passWord 密码
     * @since  1.0
     * @return bool
     **/
    public function AddUser( $userName, $passWord ){
        return $this->setUserData($userName,$passWord);
    }

    /**
     * addUser
     * 用户名是否存在
     * @access public
     * @param  string  $userName 用户名
     * @since  1.0
     * @return bool
     **/
    public function UserExists( $userName ) {
        if (file_exists($this->userFile($userName))){
            return true;
        }else{
            return false;
        }
    }

    /**
     * getUserInfo
     * 获取用户信息
     * @param $userName
     * @return bool|mixed
     */
    public function getUserInfo($userName){
        return $this->getUserData($userName);
    }

    /**
     * addUser
     * 删除一个用户
     * @access public
     * @param  string  $userName 用户名
     * @since  1.0
     * @return bool
     **/
    public function delUser( $userName ){
        if ( $this->delUserData($userName) ){
            return true;
        }else{
            return false;
        }
    }

    /**
     * addUser
     * 检查用户登录
     * @access public
     * @param  string  $userName 用户名
     * @param  string $passWord 密码
     * @since  1.0
     * @return bool
     **/
    public function checkLogin( $userName, $passWord ){
        $userData = $this->getUserData($userName);
        $passWord = $this->mkPassWord($passWord);
        if (!empty($passWord) && $userData["passWord"] === $passWord) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * hasUser
     * 检查是否用用户
     * @access public
     * @since  1.0
     * @return bool
     **/
    public function hasUser(){
        if($this->userDirIsEmpty()){
            return false;
        }else{
            return true;
        }
    }

    /**
     * userFile
     * 用户信息保存文件路径
     * @param $userName
     * @return string
     */
    private function userFile($userName ){
        $userFile = $this->getDataBaseDir().DIRECTORY_SEPARATOR.md5($userName).".json";
        return $userFile;
    }

    /**
     * getUserData
     * 获取用户信息
     * @param $userName
     * @return bool|mixed
     */
    private function getUserData($userName ){
        if($this->UserExists($userName)){
            $userJson = file_get_contents($this->userFile($userName));
            if ($userJson){
                return json_decode($userJson,true);
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    /**
     * setUserData
     * 写入用户数据
     * @param $userName
     * @param $passWord
     * @return bool
     */
    private function setUserData($userName, $passWord ){
        if ($this->UserExists($userName)) {
            return false;
        }
        $data = array(
            "userName"=>$userName,
            "passWord"=>$this->mkPassWord($passWord),
            "registerTime"=>time(),
        );
        $userFile = $this->userFile($userName);
        $dataStr = json_encode($data);
        if( file_put_contents($userFile,$dataStr) ){
            return true;
        }else{
            return true;
        }
    }

    /**
     * delUserData
     * 删除用户数据
     * @param $userName
     * @return bool
     */
    private function delUserData( $userName ){
        $userFile = $this->userFile($userName);
        if( file_exists( $userFile )  && unlink($userFile)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * getDataBaseDir
     * 获取数据存储目录
     * @access public
     * @since  1.0
     * @return string
     **/
    public function getDataBaseDir(){
        return $this->dataBaseDir;
    }

    /**
     * @param $passWord
     * @return string
     */
    private function mkPassWord($passWord ){
        if (is_string($passWord) && !empty($passWord)) {
            return hash("sha256",md5($passWord."*3d00#98")."52@!223#");
        }else{
            return "";
        }
    }

    /**
     * userDirIsEmpty
     * 目录是否为空
     * @return bool
     */
    private function userDirIsEmpty(){
        $fileList = scandir($this->getDataBaseDir());
        if ($fileList && count($fileList) > 2){
            return false;
        }else{
            return true;
        }
    }
}