### 常量定义插件

````php
/**
 * @value("PASS","通过")
 * @value("REFUSE","拒绝")
 * @value("WAIT","待审核")
 */
class testConst extends \Lit\Utils\LiConst
{
    const PASS = 1; // 通过
    const REFUSE = 2; // 拒绝
    const WAIT = 3; // 待审核
}

````

#### 1. 获取常量数组形态

```php
var_dump(testConst::toArray()); 
//array(3) {
//  [1]=>
//  string(6) "通过"
//  [2]=>
//  string(6) "拒绝"
//  [3]=>
//  string(9) "待审核"
//}
```

#### 2. 获取常量描述

```php
var_dump(testConst::getComment(1)); 
//string(6) "通过"
var_dump(testConst::getComment(testConst::REFUSE));
//string(6) "拒绝" 
var_dump(testConst::getComment(testConst::WAIT));
//string(9) "待审核"
```