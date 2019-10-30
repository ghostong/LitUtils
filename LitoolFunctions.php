<?php

spl_autoload_register( 'liSplLoadLitool' );
spl_autoload_extensions( '.php' );
function liSplLoadLitool ( $ClassName ) {
    $IncludePath = __DIR__.DIRECTORY_SEPARATOR.'src';
    set_include_path( get_include_path(). ':'. $IncludePath );
    $ClassFile = end ( explode( '\\', $ClassName ) );
    spl_autoload ( $ClassFile );
}

if (!function_exists('liRegexArray')){
    function liRegexArray ( $array=array(),$regex='' ){
        return Lit\Litool\LiArray::RegexArray($array,$regex) ;
    }
}

if (!function_exists('liArrayReplace')){
    function liArrayReplace( $search, $replace, $array ){
        return Lit\Litool\LiArray::ArrayReplace($search,$replace,$array) ;
    }
}

if (!function_exists('liXmlToArray')){
    function liXmlToArray($xml){
        return Lit\Litool\LiArray::XmlToArray($xml) ;
    }
}

if (!function_exists('liRandStr')){
    function liRandStr ( $len=8, $number=true, $letter=false, $capitals=false , $symbols=false ){
        return Lit\Litool\LiString::RandStr($len,$number,$letter,$capitals,$symbols) ;
    }
}

if (!function_exists('liSubStrTo')){
    function liSubStrTo( $haystack, $needle ){
        return Lit\Litool\LiString::SubStrTo($haystack,$needle) ;
    }
}

if (!function_exists('liStrEncode')){
    function liStrEncode($Str){
        return Lit\Litool\LiString::StrEncode($Str) ;
    }
}

if (!function_exists('liStrDecode')){
    function liStrDecode($Str){
        return Lit\Litool\LiString::StrDecode($Str) ;
    }
}

if (!function_exists('liStrLimit')){
    function liStrLimit($value, $limit = 100, $end = '...'){
        return Lit\Litool\LiString::StrLimit($value,$limit,$end) ;
    }
}

if (!function_exists('liReplaceStringVariable')){
    function liReplaceStringVariable($string,$varArr){
        return Lit\Litool\LiString::ReplaceStringVariable($string,$varArr) ;
    }
}

if (!function_exists('liMicroTime')){
    function liMicroTime (){
        return Lit\Litool\LiDate::MicroTime() ;
    }
}

if (!function_exists('liMilliTime')){
    function liMilliTime (){
        return Lit\Litool\LiDate::MilliTime() ;
    }
}

if (!function_exists('liDateFormat')){
    function liDateFormat ( $ts ){
        return Lit\Litool\LiDate::DateFormat($ts) ;
    }
}

if (!function_exists('liNextMonth')){
    function liNextMonth ( $date='', $format='Y-m' ){
        return Lit\Litool\LiDate::NextMonth($date,$format) ;
    }
}

if (!function_exists('liLastMonth')){
    function liLastMonth ( $date='',$format='Y-m' ){
        return Lit\Litool\LiDate::LastMonth($date,$format) ;
    }
}

if (!function_exists('liTodayRemainTime')){
    function liTodayRemainTime (){
        return Lit\Litool\LiDate::TodayRemainTime() ;
    }
}

if (!function_exists('liBase10to62')){
    function liBase10to62( $n ){
        return Lit\Litool\LiMath::Base10to62($n) ;
    }
}

if (!function_exists('liBase62to10')){
    function liBase62to10( $s ){
        return Lit\Litool\LiMath::Base62to10($s) ;
    }
}

if (!function_exists('liBetween')){
    function liBetween ( $num, $start, $end ){
        return Lit\Litool\LiMath::Between($num,$start,$end) ;
    }
}

if (!function_exists('liGetRemoteAddr')){
    function liGetRemoteAddr (){
        return Lit\Litool\LiSundry::GetRemoteAddr() ;
    }
}

if (!function_exists('liSendHttpStatus')){
    function liSendHttpStatus( $code ){
        return Lit\Litool\LiSundry::SendHttpStatus($code) ;
    }
}

if (!function_exists('liGetWeight')){
    function liGetWeight( $wd ){
        return Lit\Litool\LiSundry::GetWeight($wd) ;
    }
}

if (!function_exists('liIsLocalIp')){
    function liIsLocalIp( $IP ){
        return Lit\Litool\LiSundry::IsLocalIp($IP) ;
    }
}

if (!function_exists('liIsIdNumber18')){
    function liIsIdNumber18 ( $IdNum, $Gender=Null ){
        return Lit\Litool\LiSundry::IsIdNumber18($IdNum,$Gender) ;
    }
}

if (!function_exists('liIsIdNumber15')){
    function liIsIdNumber15 ( $IdNum, $Gender=Null ){
        return Lit\Litool\LiSundry::IsIdNumber15($IdNum,$Gender) ;
    }
}

