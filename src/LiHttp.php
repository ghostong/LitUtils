<?php

namespace Lit\Utils;
/**
 * LiHttp: Http 请求
 * @author  litong
 * @since   1.0
 **/
class LiHttp
{

    private $method = "";
    private $params = [];
    private $header = [];
    private $timeout = 30;
    private $curlOption = [];
    private $url = "";
    private $cookieFile = "";
    private $userAgent = "";
    private $savePath = "";
    private $result = ['errno' => 0, 'msg' => "", 'info' => [], 'result' => ""];
    private $postFile = [];
    private $defUserAgent = [
        "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36 OPR/26.0.1656.60",
        "Opera/8.0 (Windows NT 5.1; U; en)",
        "Mozilla/5.0 (Windows NT 5.1; U; en; rv:1.8.1) Gecko/20061208 Firefox/2.0.0 Opera 9.50",
        "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0",
        "Mozilla/5.0 (X11; U; Linux x86_64; zh-CN; rv:1.9.2.10) Gecko/20100922 Ubuntu/10.10 (maverick) Firefox/3.6.10",
        "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.71 Safari/537.1 LBBROWSER",
        "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E; LBBROWSER)",
        "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; QQDownload 732; .NET4.0C; .NET4.0E; LBBROWSER)",
        "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E; QQBrowser/7.0.3698.400)",
        "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; QQDownload 732; .NET4.0C; .NET4.0E)",
        "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.84 Safari/535.11 SE 2.X MetaSr 1.0",
        "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; SV1; QQDownload 732; .NET4.0C; .NET4.0E; SE 2.X MetaSr 1.0)"
    ];

    /**
     * GET 请求
     * @param $url
     * @return LiHttp
     */
    public function get($url) {
        $this->method = "GET";
        $this->url = $url;
        return $this;
    }

    /**
     * POST 请求
     * @param $url
     * @return LiHttp
     */
    public function post($url) {
        $this->method = "POST";
        $this->url = $url;
        return $this;
    }

    /**
     * 设置 POST文件
     * @date 2020/12/23
     * @param array $file
     * @return LiHttp
     */
    public function postFile($file) {
        $this->postFile = $file;
        return $this;
    }

    /**
     * DELETE 请求
     * @param $url
     * @return LiHttp
     */
    public function delete($url) {
        $this->method = "DELETE";
        $this->url = $url;
        return $this;
    }

    /**
     * PUT 请求
     * @param $url
     * @return LiHttp
     */
    public function put($url) {
        $this->method = "PUT";
        $this->url = $url;
        return $this;
    }

    /**
     * POSTJSON 自定义请求
     * @param $url
     * @param $json
     * @return LiHttp
     */
    public function postJson($url, $json) {
        return $this->post($url)->setHeader(["Content-Type: application/json"])->setParam($json);
    }

    /**
     * setParam 设置HTTP请求参数
     * @param $params
     * @return LiHttp
     */
    public function setParam($params = []) {
        $this->params = $params;
        return $this;
    }

    /**
     * setHeader 设置HTTP请求header
     * @param $header
     * @return LiHttp
     */
    public function setHeader($header = []) {
        $this->header = array_unique(array_merge($this->header, $header));
        return $this;
    }

    /**
     * setTimeout 设置HTTP超时时间
     * @param $timeout
     * @return LiHttp
     */
    public function setTimeout($timeout) {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * setTimeout 设置Curl其他参数
     * @param $options
     * @return LiHttp
     */
    public function setCurlOpt($options) {
        $this->curlOption = array_merge($this->curlOption, $options);
        return $this;
    }

    /**
     * setCookieFile 设置Cookie保存文件
     * @param $cookieFile
     * @return LiHttp
     */
    public function setCookieFile($cookieFile) {
        $this->cookieFile = $cookieFile;
        return $this;
    }

    /**
     * setUserAgent 设置UA
     * @param $userAgent
     * @return LiHttp
     */
    public function setUserAgent($userAgent = "rand") {
        if ($userAgent == "rand") {
            $this->userAgent = $this->defUserAgent[array_rand($this->defUserAgent, 1)];
        } else {
            $this->userAgent = $userAgent;
        }
        return $this;
    }

    /**
     * setCookieFile 设置Cookie保存文件
     * @param $savePath
     * @return LiHttp
     */
    public function setSavePath($savePath) {
        $this->savePath = $savePath;
        return $this;
    }

    /**
     * setResult 设置返回值
     * @param $errno
     * @param $msg
     * @param $info
     * @param $result
     * @return array
     */
    public function setResult($errno, $msg, $info, $result) {
        $this->result["errno"] = $errno;
        $this->result["msg"] = $msg;
        $this->result["info"] = $info;
        $this->result["result"] = $result;
        return $this->result;
    }

    /**
     * send 执行发送请求
     * @return array 请求结果
     */
    public function send() {
        $ch = curl_init();
        $option = [];
        if (substr($this->url, 0, 8) == 'https://') {
            $option[CURLOPT_SSL_VERIFYPEER] = false;
            $option[CURLOPT_SSL_VERIFYHOST] = 2;
        }
        $option[CURLOPT_FOLLOWLOCATION] = true;
        $option[CURLOPT_MAXREDIRS] = 5;
        if (is_array($this->params) && empty($this->postFile)) {
            $requestParams = http_build_query($this->params);
        } else {
            $requestParams = $this->params;
        }
        if (!empty($this->postFile)) {
            foreach ($this->postFile as $key => $val) {
                $requestParams[$key] = new \CURLFile($val);
            }
        }
        switch ($this->method) {
            case 'POST':
                $option[CURLOPT_POST] = true;
                $option[CURLOPT_POSTFIELDS] = $requestParams;
                $option[CURLOPT_URL] = $this->url;
                break;
            case 'PUT':
                $option[CURLOPT_CUSTOMREQUEST] = 'PUT';
                $option[CURLOPT_POSTFIELDS] = $requestParams;
                $option[CURLOPT_URL] = $this->url;
                break;
            case 'DELETE':
                $option[CURLOPT_CUSTOMREQUEST] = 'DELETE';
                $option[CURLOPT_POSTFIELDS] = $requestParams;
                $option[CURLOPT_URL] = $this->url;
                break;
            default:
                $extStr = (strpos($this->url, '?') !== false) ? '&' : '?';
                $option[CURLOPT_URL] = $this->url . ($requestParams ? ($extStr . $requestParams) : '');
                break;
        }
        $option[CURLOPT_USERAGENT] = $this->userAgent;
        $option[CURLOPT_CONNECTTIMEOUT] = $this->timeout;
        $option[CURLOPT_TIMEOUT] = $this->timeout;
        $option[CURLOPT_RETURNTRANSFER] = true;
        if ($this->header) {
            $option[CURLOPT_HTTPHEADER] = $this->header;
        }
        if ($this->cookieFile) {
            $option[CURLOPT_COOKIEJAR] = $this->cookieFile;
            $option[CURLOPT_COOKIEFILE] = $this->cookieFile;
        }
        curl_setopt_array($ch, $option + $this->curlOption);
        $result = curl_exec($ch);
        if (curl_errno($ch) > 0) {
            $return = $this->setResult(curl_errno($ch), curl_error($ch), curl_getinfo($ch), "");
            curl_close($ch);
            return $return;
        } else {
            $info = curl_getinfo($ch);
            curl_close($ch);
            if ($this->savePath) {
                file_put_contents($this->savePath, $result);
                return $this->setResult(0, '', $info, $this->savePath);
            } else {
                return $this->setResult(0, '', $info, $result);
            }
        }
    }

    /**
     * download 执行下载请求
     * @return array 请求结果
     */
    public function download() {
        $ch = curl_init();
        $option[CURLOPT_URL] = $this->url;
        if (substr($this->url, 0, 8) == 'https://') {
            $option[CURLOPT_SSL_VERIFYPEER] = false;
            $option[CURLOPT_SSL_VERIFYHOST] = 2;
        }
        $option[CURLOPT_HEADER] = 0;
        if ($this->header) {
            $option[CURLOPT_HTTPHEADER] = $this->header;
        }
        if ($this->timeout) {
            $option[CURLOPT_TIMEOUT] = $this->timeout;
        }
        $option[CURLOPT_RETURNTRANSFER] = 1;
        $option[CURLOPT_NOPROGRESS] = 0;
        $option[CURLOPT_FOLLOWLOCATION] = true;
        $option[CURLOPT_BUFFERSIZE] = 64000;
        if ($this->method == "POST") {
            $option[CURLOPT_POST] = true;
        } else {
            $option[CURLOPT_POST] = false;
        }
        if ($this->params) {
            $option[CURLOPT_POSTFIELDS] = $this->params;
        }
        if ($this->savePath) {
            $fp = fopen($this->savePath, 'wb');
            $option[CURLOPT_FILE] = $fp;
        }
        curl_setopt_array($ch, $option + $this->curlOption);
        $result = curl_exec($ch);
        $curlInfo = curl_getinfo($ch);
        if (curl_errno($ch) || $curlInfo['http_code'] != 200) {
            $return = $this->setResult(curl_errno($ch), curl_error($ch), curl_getinfo($ch), "");
            curl_close($ch);
            @unlink($this->savePath);
            return $return;
        } else {
            $info = curl_getinfo($ch);
            curl_close($ch);
            if ($this->savePath) {
                isset($fp) && is_resource($fp) && fclose($fp);
                return $this->setResult(0, '', $info, $this->savePath);
            } else {
                return $this->setResult(0, '', $info, $result);
            }
        }
    }
}