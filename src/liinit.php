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
}
