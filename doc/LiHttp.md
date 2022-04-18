### HTTP请求

````php
$http = new \Lit\Utils\LiHttp();
````

#### 1. 发送一个GET请求

````php
$response = $http->setParam(["a" => 1])->get("http://www.google.com?b=2")->send();
var_dump($response);
````

#### 2. 发送一个POST请求

````php
$response = $http->setParam(["a" => 1])->post("http://www.google.com?b=2")->send();
var_dump($response);
````

#### 3. POST JSON

````php
$response = $http->postJson("http://www.google.com", "{}")->setHeader(["aa:11"])->send();
var_dump($response);
````

#### 4. 发送一个文件上传

````php
$response = $http->setParam(["a" => 1])->postFile(["file" => "/Users/Desktop/comic.zip", "file2" => "/Users/Desktop/2.jpg"])->post("http://google.com")->send();
var_dump($response);
````

#### 5. 发送一个文件下载

````php
$response = $http->get("https://www.google.com/aaa.jpg")->setSavePath("./aaa.jpg")->download(false);
var_dump($response);
````