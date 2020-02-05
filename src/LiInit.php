<?php

namespace Lit\Litool;

/**
 * liarray: litool PHP 数组部分
 * @author  litong
 * @since   1.0
 **/

class LiInit {

    /**
     * init
     * 测试调用
     * @access public
     * @since  1.0
     **/
    public static function init (){
        try {
            echo liarray::init();
        } catch ( \Exception $e ) {
            echo $e->getMessage();
        }
    }


    /**
     * Class2Function
     * 类转函数,方便非composer安装与快速调用
     * @access public
     * @param string $SaveTo 指定函数保存位置
     * @since  1.0
     **/
    public static function Class2Function ( $SaveTo = '' ) {
        $AutoLoad = '';
        $AutoLoad .= "spl_autoload_register( 'liSplLoadLitool' );\n";
        $AutoLoad .= "spl_autoload_extensions( '.php' );\n";
        $AutoLoad .= "function liSplLoadLitool ( \$ClassName ) {\n";
        $AutoLoad .= "    \$IncludePath = __DIR__.DIRECTORY_SEPARATOR.'src';\n";
        $AutoLoad .= "    set_include_path( get_include_path(). ':'. \$IncludePath );\n";
        $AutoLoad .= "    \$ClassFile = end ( explode( '\\\\', \$ClassName ) );\n";
        $AutoLoad .= "    spl_autoload ( \$ClassFile );\n";
        $AutoLoad .= "}";
        $ClassList = array (
            'Lit\Litool\LiArray',
            'Lit\Litool\LiString',
            'Lit\Litool\LiDate',
            'Lit\Litool\LiMath',
            'Lit\Litool\LiSundry'
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
        $OutPut = "<?php\n\n".$AutoLoad."\n\n".$OutPut;
        if (''==$SaveTo) {
            $SaveTo = dirname(__DIR__).'/LitoolFunctions.php';
        }
        $SFI = new \SplFileInfo(dirname($SaveTo));
        if ( $SFI -> isWritable () ) {
            file_put_contents($SaveTo,$OutPut);
            echo '函数文件保存在 ',$SaveTo," 请手动导入\n";
        } else {
            echo dirname($SaveTo),'目录不可写!',"\n";
        }
    }
}