<?php

namespace Lit\Utils;

class LiDebug
{
    protected static $dataCache = [];

    /**
     * 增加埋点
     * @param $log
     * @return void
     */
    public static function anchor($log = "") {
        $trace = debug_backtrace(false, 1);
        self::$dataCache[] = [
            "file" => $trace[0]["file"],
            "line" => $trace[0]["line"],
            "time" => sprintf("%01.4f", microtime(true)),
            "log" => $log
        ];
    }

    /**
     * 获取埋点记录
     * @return array
     */
    public static function getAll() {
        return self::$dataCache;
    }

    /**
     * 获取埋点格式化记录
     * @return string[]
     */
    public static function getFormat() {
        return array_map(function ($value) {
            return sprintf("[%s] %s:%d %s", $value["time"], $value["file"], $value["line"], $value["log"]);
        }, self::getAll());
    }

}