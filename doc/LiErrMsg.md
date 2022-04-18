### 错误传递

````php
class BaseClass
{
    use \Lit\Utils\LiErrMsg;

    public function test() {
        $this->setCodeMsg(1, "测试错误");
        $this->setCode(1);
        $this->setMsg("测试错误");
    }

}

$baseClass = new BaseClass();
$baseClass->test();
````

#### 1. 获取错误信息数组

```php
var_dump($baseClass->getCodeMsg());
//array(2) {
//  ["code"]=>
//  int(1)
//  ["msg"]=>
//  string(12) "测试错误"
//}
```

#### 2. 获取错误码

```php
var_dump($baseClass->getCode());
//int(1)
```

#### 3. 获取错误信息

```php
var_dump($baseClass->getMsg());
//string(12) "测试错误"
```