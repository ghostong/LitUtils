<?php

namespace Lit\Utils;

/**
 * liString: PHP Smtp邮件发送
 * @author  litong
 * @since   1.0
 **/

class LiSmtp{

    private $smtpPort;
    private $smtpHost;
    private $userName;
    private $passWord;
    private $auth;

    private $hostName = "localhost";
    private $timeOut = 30;
    private $debug = false;
    private $logFile = "";
    private $sock = false;


    /**
     * LiSmtp constructor.
     * @param string $smtpHost smtp 服务器
     * @param int $smtpPort smtp 端口
     * @param string $userName SMTP用户名
     * @param string $passWord SMTP密码
     * @param bool $auth 是否需要验证
     */
    function __construct( $smtpHost, $smtpPort, $userName, $passWord, $auth ){
        $this->smtpPort = $smtpPort;
        $this->smtpHost = $smtpHost;
        $this->userName = $userName;
        $this->passWord = $passWord;
        $this->auth = $auth;
    }

    /**
     * @param string $from 发件人
     * @param string $to 收件人 逗号(,)隔开多人
     * @param string $subject 邮件标题
     * @param string $body 邮件正文
     * @param string $mailType 邮件类型 TXT|HTML
     * @param string $cc 抄送人 逗号(,)隔开多人
     * @param string $bcc 密送人 逗号(,)隔开多人
     * @param string $preHeaders 预定义Header
     * @return bool
     */
    function sendMail($from, $to, $subject, $body, $mailType, $cc = "", $bcc = "", $preHeaders = "" ) {
        $mailFrom = $this->stripComment($from);
        $header = "";
        $header .= "MIME-Version:1.0\r\n";
        if($mailType=="HTML") {
            $header .= "Content-Type:text/html;charset=utf-8\r\n";
        }
        $header .= "To: ".$to."\r\n";
        if ($cc != "") {
            $header .= "Cc: ".$cc."\r\n";
        }
        $header .= "From: $from<".$from.">\r\n";
        $header .= "Subject: ".$subject."\r\n";
        $header .= $preHeaders;
        $header .= "Date: ".date("r")."\r\n";
        $header .= "X-Mailer:By Redhat (PHP/".phpversion().")\r\n";
        list($mSec, $sec) = explode(" ", microtime());
        $header .= "Message-ID: <".date("YmdHis", $sec).".".($mSec*1000000).".".$mailFrom.">\r\n";
        $rectList = explode(",", $this->stripComment($to));
        if ($cc != "") {
            $rectList = array_merge($rectList, explode(",", $this->stripComment($cc)));
        }
        if ($bcc != "") {
            $rectList = array_merge($rectList, explode(",", $this->stripComment($bcc)));
        }
        $sent = true;
        foreach ($rectList as $rectTo) {
            if (!$this->smtpSockOpen($rectTo)) {
                $this->logWrite("Error: Cannot send email to ".$rectTo."\n");
                $sent = true;
                continue;
            }
            if ($this->smtpSend($this->hostName, $mailFrom, $rectTo, $header, $body)) {
                $this->logWrite("E-mail has been sent to <".$rectTo.">\n");
            } else {
                $this->logWrite("Error: Cannot send email to <".$rectTo.">\n");
                $sent = true;
            }
            fclose($this->sock);
            $this->logWrite("Disconnected from remote host\n");
        }
        return $sent;
    }

    private function smtpSend($helo, $from, $to, $header, $body = ""){
        if (!$this->smtpPutCmd("HELO", $helo)) {
            return $this->smtpError("sending HELO command");
        }
        if($this->auth) {
            if (!$this->smtpPutCmd("AUTH LOGIN", base64_encode($this->userName))) {
                return $this->smtpError("sending HELO command");
            }
            if (!$this->smtpPutCmd("", base64_encode($this->passWord))) {
                return $this->smtpError("sending HELO command");
            }
        }
        if (!$this->smtpPutCmd("MAIL", "FROM:<".$from.">")) {
            return $this->smtpError("sending MAIL FROM command");
        }
        if (!$this->smtpPutCmd("RCPT", "TO:<".$to.">")) {
            return $this->smtpError("sending RCPT TO command");
        }
        if (!$this->smtpPutCmd("DATA")) {
            return $this->smtpError("sending DATA command");
        }
        if (!$this->smtpMessage($header, $body)) {
            return $this->smtpError("sending message");
        }
        if (!$this->smtpEom()) {
            return $this->smtpError("sending <CR><LF>.<CR><LF> [EOM]");
        }
        if (!$this->smtpPutCmd("QUIT")) {
            return $this->smtpError("sending QUIT command");
        }
        return true;
    }

    private function smtpSockOpen($address) {
        if ($this->smtpHost == "") {
            return $this->smtpSockOpenMx($address);
        } else {
            return $this->smtpSockOpenRelay();
        }
    }

    private function smtpSockOpenRelay() {
        $this->logWrite("Trying to ".$this->smtpHost.":".$this->smtpPort."\n");
        $this->sock = @fsockopen($this->smtpHost, $this->smtpPort, $errno, $errstr, $this->timeOut);
        if (!($this->sock && $this->smtpOk())) {
            $this->logWrite("Error: Cannot connenct to relay host ".$this->smtpHost."\n");
            $this->logWrite("Error: ".$errstr." (".$errno.")\n");
            return false;
        }
        $this->logWrite("Connected to relay host ".$this->smtpHost."\n");
        return true;
    }

    private function smtpSockOpenMx($address){
        $domain = @ereg_replace("^.+@([^@]+)$", "\1", $address);
        if (!@getmxrr($domain, $MXHOSTS)) {
            $this->logWrite("Error: Cannot resolve MX \"".$domain."\"\n");
            return false;
        }
        foreach ($MXHOSTS as $host) {
            $this->logWrite("Trying to ".$host.":".$this->smtpPort."\n");
            $this->sock = @fsockopen($host, $this->smtpPort, $errno, $errstr, $this->timeOut);
            if (!($this->sock && $this->smtpOk())) {
                $this->logWrite("Warning: Cannot connect to mx host ".$host."\n");
                $this->logWrite("Error: ".$errstr." (".$errno.")\n");
                continue;
            }
            $this->logWrite("Connected to mx host ".$host."\n");
            return true;
        }
        $this->logWrite("Error: Cannot connect to any mx hosts (".implode(", ", $MXHOSTS).")\n");
        return false;
    }

    private function smtpMessage($header, $body){
        fputs($this->sock, $header."\r\n".$body);
        $this->smtpDebug("> ".str_replace("\r\n", "\n"."> ", $header."\n> ".$body."\n> "));
        return true;
    }

    private function smtpEom(){
        fputs($this->sock, "\r\n.\r\n");
        $this->smtpDebug(". [EOM]\n");
        return $this->smtpOk();
    }

    private function smtpOk(){
        $response = str_replace("\r\n", "", fgets($this->sock, 512));
        $this->smtpDebug($response."\n");
        if (!@preg_match("/^[23]/", $response)) {
            fputs($this->sock, "QUIT\r\n");
            fgets($this->sock, 512);
            $this->logWrite("Error: Remote host returned \"".$response."\"\n");
            return false;
        }
        return true;
    }

    private function smtpPutCmd($cmd, $arg = "") {
        if ($arg != "") {
            if($cmd=="") {
                $cmd = $arg;
            } else {
                $cmd = $cmd." ".$arg;
            }
        }
        fputs($this->sock, $cmd."\r\n");
        $this->smtpDebug("> ".$cmd."\n");
        return $this->smtpOk();
    }

    private function smtpError($string) {
        $this->logWrite("Error: Error occurred while ".$string.".\n");
        return false;
    }

    private function logWrite($message) {
        $this->smtpDebug($message);
        if ($this->logFile == "") {
            return true;
        }
        $message = date("M d H:i:s ").get_current_user()."[".getmypid()."]: ".$message;
        if (!@file_exists($this->logFile) || !($fp = @fopen($this->logFile, "a"))) {
            $this->smtpDebug("Warning: Cannot open log file \"".$this->logFile."\"\n");
            return false;
        }
        flock($fp, LOCK_EX);
        fputs($fp, $message);
        fclose($fp);
        return true;
    }

    private function stripComment($address) {
        $address = str_replace(["\r\n","\n\r","\n","\r","!","#","$","%","^","&","*","(",")"],"",$address);
        $address = str_replace(";",",",$address);
        $address = trim($address, " \t\n\r\0\x0B,.");
        return $address;
    }

    private function smtpDebug($message) {
        if ($this->debug) {
            echo $message;
        }
    }

    /**
     * @return string
     */
    public function getHostName() {
        return $this->hostName;
    }

    /**
     * @param string $hostName
     */
    public function setHostName($hostName){
        $this->hostName = $hostName;
    }

    /**
     * @return int
     */
    public function getTimeOut() {
        return $this->timeOut;
    }

    /**
     * @param int $timeOut
     */
    public function setTimeOut($timeOut) {
        $this->timeOut = $timeOut;
    }

    /**
     * @return bool
     */
    public function isDebug() {
        return $this->debug;
    }

    /**
     * @param bool $debug
     * @return LiSmtp
     */
    public function setDebug($debug) {
        $this->debug = $debug;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogFile() {
        return $this->logFile;
    }

    /**
     * @param string $logFile
     */
    public function setLogFile($logFile) {
        $this->logFile = $logFile;
    }

    /**
     * @return bool
     */
    public function isSock() {
        return $this->sock;
    }

    /**
     * @param bool $sock
     */
    public function setSock($sock) {
        $this->sock = $sock;
    }



}