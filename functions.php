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
        return lit\litool\liarray::RegexArray($array,$regex) ;
    }
}

if (!function_exists('liArrayReplace')){
    function liArrayReplace( $search, $replace, $array ){
        return lit\litool\liarray::ArrayReplace($search,$replace,$array) ;
    }
}

if (!function_exists('liRandStr')){
    function liRandStr ( $len=8, $number=true, $letter=false, $capitals=false , $symbols=false ){
        return lit\litool\listring::RandStr($len,$number,$letter,$capitals,$symbols) ;
    }
}

if (!function_exists('liSubStrTo')){
    function liSubStrTo( $haystack, $needle ){
        return lit\litool\listring::SubStrTo($haystack,$needle) ;
    }
}

if (!function_exists('liStrEncode')){
    function liStrEncode($Str){
        return lit\litool\listring::StrEncode($Str) ;
    }
}

if (!function_exists('liStrDecode')){
    function liStrDecode($Str){
        return lit\litool\listring::StrDecode($Str) ;
    }
}

if (!function_exists('liStrLimit')){
    function liStrLimit($value, $limit = 100, $end = '...'){
        return lit\litool\listring::StrLimit($value,$limit,$end) ;
    }
}

if (!function_exists('liMicroTime')){
    function liMicroTime (){
        return lit\litool\lidate::MicroTime() ;
    }
}

if (!function_exists('liMilliTime')){
    function liMilliTime (){
        return lit\litool\lidate::MilliTime() ;
    }
}

if (!function_exists('liDateFormat')){
    function liDateFormat ( $ts ){
        return lit\litool\lidate::DateFormat($ts) ;
    }
}

if (!function_exists('liNextMonth')){
    function liNextMonth ( $date='', $format='Y-m' ){
        return lit\litool\lidate::NextMonth($date,$format) ;
    }
}

if (!function_exists('liLastMonth')){
    function liLastMonth ( $date='',$format='Y-m' ){
        return lit\litool\lidate::LastMonth($date,$format) ;
    }
}

if (!function_exists('liTodayRemainTime')){
    function liTodayRemainTime (){
        return lit\litool\lidate::TodayRemainTime() ;
    }
}

if (!function_exists('liBase10to62')){
    function liBase10to62( $n ){
        return lit\litool\limath::Base10to62($n) ;
    }
}

if (!function_exists('liBase62to10')){
    function liBase62to10( $s ){
        return lit\litool\limath::Base62to10($s) ;
    }
}

if (!function_exists('liGetRemoteAddr')){
    function liGetRemoteAddr (){
        return lit\litool\lisundry::GetRemoteAddr() ;
    }
}

if (!function_exists('liSendHttpStatus')){
    function liSendHttpStatus( $code ){
        return lit\litool\lisundry::SendHttpStatus($code) ;
    }
}

if (!function_exists('liGetWeight')){
    function liGetWeight( $wd ){
        return lit\litool\lisundry::GetWeight($wd) ;
    }
}

if (!function_exists('liIsLocalIp')){
    function liIsLocalIp( $IP ){
        return lit\litool\lisundry::IsLocalIp($IP) ;
    }
}

if (!function_exists('liIsIdNumber18')){
    function liIsIdNumber18 ( $IdNum, $Gender=Null ){
        return lit\litool\lisundry::IsIdNumber18($IdNum,$Gender) ;
    }
}

if (!function_exists('liIsIdNumber15')){
    function liIsIdNumber15 ( $IdNum, $Gender=Null ){
        return lit\litool\lisundry::IsIdNumber15($IdNum,$Gender) ;
    }
}

