<?php

namespace Lit\Utils;

/**
 * 位开关
 */
class LiBitSwitch extends LiConst
{
    /**
     * 关闭某个位开关
     * @date 2023/8/7
     * @param $currBit
     * @param $bit
     * @return int
     * @author litong
     */
    public static function on($currBit, $bit) {
        return $currBit | $bit;
    }

    /**
     * 打开某个位开关
     * @date 2023/8/7
     * @param $currBit
     * @param $bit
     * @return int
     * @author litong
     */
    public static function off($currBit, $bit) {
        return $currBit & ($bit ^ self::getFullBit());
    }

    /**
     * 某个位是否开
     * @date 2023/8/7
     * @param $currBit
     * @param $bit
     * @return bool
     * @author litong
     */
    public static function isOn($currBit, $bit) {
        return ($currBit & $bit) === $bit;
    }

    /**
     * 某个位是否关
     * @date 2023/8/7
     * @param $currBit
     * @param $bit
     * @return bool
     * @author litong
     */
    public static function isOff($currBit, $bit) {
        return ($currBit & $bit) === 0;
    }

    /**
     * 所有开关为开的状态
     * @date 2023/8/7
     * @return float|int
     * @throws \Exception
     * @author litong
     */
    public static function getFullBit() {
        return array_sum(self::getValues());
    }

    /**
     * 开关结果转为二进制字符串
     * @date 2023/8/7
     * @param $decimal
     * @return string
     * @author litong
     */
    public static function toBinStr($decimal) {
        return base_convert($decimal, 10, 2);
    }

    /**
     * 获取某位为开时, 所有可能的值
     * @date 2023/8/7
     * @param $bit
     * @return array
     * @throws \Exception
     * @author litong
     */
    public static function getBitAllOn($bit) {
        $fullBit = self::getFullBit();
        $allBitOn = [];
        for ($i = 0; $i <= $fullBit; $i++) {
            if (self::isOn($i, $bit)) {
                $allBitOn[] = $i;
            }
        }
        return $allBitOn;
    }
}