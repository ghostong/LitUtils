<?php

namespace Lit\Utils;

class LiLogs
{
    protected static $cacheKey = [];

    const FORMAT_CSV = 'csv';
    const FORMAT_JSON = 'json';
    const FORMAT_SSV = 'ssv';

    const AUTO_TIME = '_auto_time';

    /**
     * json 格式输出
     * @date 2023/7/19
     * @param array $logs
     * @return void
     * @author litong
     */
    public static function echoJson($logs) {
        $logs = self::addTime($logs);
        echo self::format($logs, self::FORMAT_JSON);
    }

    /**
     * csv 格式输出
     * @date 2023/7/19
     * @param string|int ...$logs
     * @return void
     * @author litong
     */
    public static function echoCsv(...$logs) {
        $logs = self::addTime($logs);
        echo self::format($logs, self::FORMAT_CSV);
    }

    /**
     * 空格 分隔格式输出
     * @date 2023/7/19
     * @param string|int ...$logs
     * @return void
     * @author litong
     */
    public static function echoSsv(...$logs) {
        $logs = self::addTime($logs);
        echo self::format($logs, self::FORMAT_SSV);
    }

    protected static function format($data, $format) {
        if (empty($data)) {
            return '';
        }
        switch ($format) {
            case self::FORMAT_CSV:
                return LiString::toCsvString($data) . "\n";
            case self::FORMAT_SSV:
                $data[self::AUTO_TIME] = '[' . $data[self::AUTO_TIME] . ']';
                return implode(" ", $data) . "\n";
            default:
                return json_encode($data, JSON_UNESCAPED_UNICODE) . "\n";
        }
    }

    protected static function addTime($logs) {
        return array_merge([self::AUTO_TIME => date('Y-m-d H:i:s')], $logs);
    }

    /**
     * 贮藏日志
     * @date 2023/7/19
     * @param array $logs
     * @return bool
     * @author litong
     */
    public static function stage($logs) {
        self::$cacheKey[] = self::addTime($logs);
        return true;
    }

    /**
     * 获取所有贮藏日志
     * @date 2023/7/19
     * @return array
     * @author litong
     */
    public static function getStage() {
        return self::$cacheKey;
    }

    /**
     * 清空所有贮藏日志
     * @date 2023/7/19
     * @return bool
     * @author litong
     */
    public static function cleanStage() {
        self::$cacheKey = [];
        return true;
    }

    /**
     * 贮藏的日志写入到文件
     * @date 2023/7/19
     * @param string $fileName
     * @param array $logs
     * @param string $format
     * @return void
     * @author litong
     */
    public static function toFile($fileName, $logs = [], $format = self::FORMAT_JSON) {
        if (!empty($logs)) {
            $logs = self::addTime($logs);
        }

        $fp = fopen($fileName, 'w');
        foreach (self::getStage() as $value) {
            fwrite($fp, self::format($value, $format));
        }
        self::cleanStage();
        fwrite($fp, self::format($logs, $format));
        fclose($fp);
    }

}