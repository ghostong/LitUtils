### 文件类型

````php
use  \Lit\Utils\LiFileType;
````

#### 判断文件是否文件

````php
var_dump(LiFileType::isFile("./a.jpg"));
````

#### 判断文件是否图片

````php
var_dump(LiFileType::isImage("./a.jpg"));
````

#### 判断文件是否视频

````php
var_dump(LiFileType::isVideo("./a.mp4"));
````

#### 判断文件是否音频

````php
var_dump(LiFileType::isAudio("./a.mp3"));
````

#### 判断文件是否文本

````php
var_dump(LiFileType::isText("./a.php"));
````