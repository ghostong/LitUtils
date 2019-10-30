<?php

require(__DIR__.'/vendor/autoload.php');

use Lit\Litool\LiInit;

#初始化调用 可以确定依赖是否完善,只调用一次即可
LiInit::init();
echo "\n";

#类转函数,方便非composer安装与快速调用[此方法会生成文件,默认为 dirname(__DIR__).'/functions.php']
LiInit::Class2Function();

################################

use  \Lit\Litool\LiArray;

#通过正则表达式匹配一维数组的值,返回正则表达式匹配部分
var_dump ( LiArray::RegexArray (['aa','bb','cc','ab','ac'],'/^a/') );

#归替换多维数中指定的字符串
var_dump (LiArray::ArrayReplace('a','b',['aacd','aag','have','aa'=>['cba']]));

#归替换多维数中指定的字符串
var_dump (LiArray::ArrayReplace('a','b',['aacd','aag','have','aa'=>['cba']]));

#标准的XML解析成数组
$xml = '<?xml version="1.0" encoding="UTF-8"?> <note><to>Tove</to><from>Jani</from><heading>Reminder</heading></note>';
var_dump (LiArray::XmlToArray($xml));

################################

use  \Lit\Litool\LiString;

#获取随机数字符串
var_dump ( LiString::RandStr(8,true,true,true,true) );

#返回 haystack 在首次 needle 出现之前的字符串
var_dump ( LiString::SubStrTo('i can say my abc !',' my') );

#简单字符串可逆加密(加密)
$Encode = LiString::StrEncode('可逆运算');
var_dump ( $Encode );

#简单字符串可逆加密(解密)
$Decode = LiString::StrDecode($Encode);
var_dump ( $Decode );

#限制字符串的字符数量
var_dump ( LiString::StrLimit('不a管b什么样的字符都可以了',7) );

#替换字符串中的变量占位符
var_dump (LiString::ReplaceStringVariable('我叫{$name}',array('name'=>'litool')));

################################

use  \Lit\Litool\LiDate;

#返回当前时间以秒为单位的微秒数
var_dump ( LiDate::MicroTime() );

#回当前时间以秒为单位的毫秒数
var_dump ( LiDate::MilliTime() );

#返回中文格式化的时间
var_dump ( LiDate::DateFormat('1494475359') );

#返回下个月是几月
var_dump ( LiDate::NextMonth('2015-2-28') );

#返回上个月是几月
var_dump ( LiDate::LastMonth('2015-01-01') );

#返回今天还剩多少秒
var_dump ( LiDate::TodayRemainTime() );

################################

use  \Lit\Litool\LiMath;

#10进制转62进制
var_dump ( LiMath::Base10to62(40000) );

#62进制转10进制
var_dump ( LiMath::Base62to10('ACG97') );

#数字是否在两个数中间(包含边界)
var_dump ( LiMath::Between(6,1,6) );

################################

use  \Lit\Litool\LiSundry;

#获取用户来源IP
var_dump ( LiSundry::GetRemoteAddr() );

#发送http状态码
LiSundry::SendHttpStatus(404) ;

#根据权重随机返回备选数据
$wd = array (
    array ( 'w' => 60, 'v' => '我是60%概率') ,
    array ( 'w' => 35, 'v' => '我是35%概率') ,
    array ( 'w' => 5 , 'v' => '我是5%概率') ,
);
var_dump ( LiSundry::GetWeight( $wd ) );

#判断是否私网IP
var_dump ( LiSundry::IsLocalIp('10.25.11.58') );

#判断是否18位身份证号
var_dump ( LiSundry::IsIdNumber18('130602199001011111',1) );

#判断是否15位身份证号
var_dump ( LiSundry::IsIdNumber15('110100010923582',0) );
