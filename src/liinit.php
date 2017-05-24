<?php 

namespace lit\litool;

/**
 * liarray: litool PHP 数组部分
 * @author  litong
 * @since   1.0
 **/

class liinit {

    /** 
     * init
     * 测试调用
     * @access public
     * @since  1.0 
     * @return mixed
     **/
    public static function init (){
        try {
            echo liarray::init();
        } catch ( \Exception $e ) {
            echo $e->getMessage();
        }
    }

    public static function Class2Function ( $SaveTo = '' ) {
        $ClassList = array (
            'lit\litool\liarray',
            'lit\litool\listring',
            'lit\litool\lidate',
            'lit\litool\limath',
            'lit\litool\lisundry'
        );
        $OutPut  = '' ;
        
        foreach ($ClassList as $class) {
            $ClassRe = new \ReflectionClass ($class);
            $FileContent = file_get_contents( $ClassRe->getFileName () );
            foreach ( $ClassRe->getMethods( ) as $method ) {
                if ( 'init' == $method -> name ) {
                    continue;
                }
                $NewFunction = 'li'.$method -> name;
                $Pattern = '/(.*)(function(.*)?'.$method -> name.'(\s)?\((.*)?\))/';
                preg_match ( $Pattern, $FileContent, $Matches);
                $FunctionName = str_replace($method -> name, $NewFunction, $Matches[2] );
                $ParamArr = array();
                foreach( $method->getParameters () as $param ) {
                        $ParamArr[] = '$'.$param->name;
                }
                $ParamStr = implode(',',$ParamArr);
                $OutPut .= "if (!function_exists('{$NewFunction}')){\n";
                $OutPut .= "    ".$FunctionName."{\n";
                $OutPut .= "        return ".$class."::".$method -> name."(".$ParamStr.") ;\n";
                $OutPut .= "    }\n}\n\n";
            }
        }
        $OutPut = "<?php\n\n".$OutPut;
        if (''==$SaveTo) {
            $SaveTo = dirname(dirname(__FILE__)).'/functions.php';
        }
        file_put_contents($SaveTo,$OutPut);
    }
}
