<?php

namespace Lit\Utils;

class LiStructures
{

    /**
     * 选择偶数形参 强制类型转换true 的下一个形参的值
     * @date 2022/3/1
     * @param mixed ...$args
     * @return mixed|null
     * @author litong
     */
    public static function trueNext(...$args) {
        $args = func_get_args();
        $argsNum = func_num_args();
        for ($i = 0; $i < $argsNum; $i++) {
            if ($i % 2 == 0 && boolval($args[$i]) === true) {
                $next = ++$i;
                return isset($args[$next]) ? $args[$next] : null;
            }
        }
        return null;
    }


}