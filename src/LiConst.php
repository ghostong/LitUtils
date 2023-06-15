<?php

namespace Lit\Utils;

class LiConst
{
    /**
     * 获取常量的数组结构
     * @date 2022/3/22
     * @return array
     * @throws \Exception
     * @author litong
     */
    public static function toArray() {
        return self::reflection();
    }

    /**
     * 获取所有常量的值
     * @date 2023/6/15
     * @return array
     * @throws \Exception
     * @author litong
     */
    public static function getValues() {
        return array_keys(self::toArray());
    }

    /**
     * 获取常量的描述
     * @date 2022/3/22
     * @param $constKey
     * @return string|null
     * @throws \Exception
     * @author litong
     */
    public static function getComment($constKey) {
        $constants = self::reflection();
        return isset($constants[$constKey]) ? $constants[$constKey] : null;
    }

    /**
     * 反射常量对象
     * @date 2022/3/22
     * @return array
     * @throws \Exception
     * @author litong
     */
    private static function reflection() {
        $rc = new \ReflectionClass(new static());
        $constants = $rc->getConstants();
        if (count(array_unique($constants)) !== count($constants)) {
            throw new \Exception("常量值不能重复");
        }

        $commentString = $rc->getDocComment();
        $pattern = "#@value+\s*\([\"\']([a-zA-Z0-9_]+)[\"\'\,\s]+(.*)[\"\']\)#";
        preg_match_all($pattern, $commentString, $matches, PREG_PATTERN_ORDER);
        $newArray = array_combine($matches[1], $matches[2]);
        $newConstants = [];

        foreach ($constants as $constName => $contValue) {
            if (isset($newArray[$constName])) {
                $newConstants[$contValue] = $newArray[$constName];
            }
        }
        return $newConstants;
    }
}