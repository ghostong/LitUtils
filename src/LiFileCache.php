<?php

namespace Lit\Utils;


class LiFileCache
{
    private static $cachePath = null;
    private static $isInit = null;

    /**
     * 初始化缓存结构
     * @date 2022/4/8
     * @param $cachePath
     * @return void
     * @throws \Exception
     * @author litong
     */
    public static function init($cachePath) {
        if (self::$isInit === null) {
            self::$cachePath = $cachePath;
            self::checkCachePath();
            self::$isInit = true;
        }
    }

    /**
     * 获取缓存
     * @date 2022/4/8
     * @param $key
     * @return mixed|null
     * @author litong
     */
    public static function get($key) {
        $key = self::mkKeyPath($key);
        $data = @file_get_contents($key);
        if (empty($data)) {
            return null;
        }
        $dataCache = self::dataDecode($data);
        if (isset($dataCache["ttl"])) {
            $time = time();
            if ($dataCache["ttl"] >= $time || $dataCache["ttl"] === 0) {
                return $dataCache["data"];
            } elseif ($dataCache["ttl"] > 0) {
                self::del($key);
                return null;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * 设置缓存
     * @date 2022/4/8
     * @param $key
     * @param $data
     * @param int $ttl
     * @return bool
     * @author litong
     */
    public static function set($key, $data, $ttl = 0) {
        $key = self::mkKeyPath($key);
        $cacheData = self::dataEncode($data, $ttl);
        if (self::mkDir(dirname($key))) {
            return false !== file_put_contents($key, $cacheData);
        } else {
            return false;
        }
    }

    /**
     * 删除缓存
     * @date 2022/4/8
     * @param $key
     * @return bool
     * @author litong
     */
    public static function del($key) {
        $key = self::mkKeyPath($key);
        return @unlink($key);
    }

    /**
     * 判断缓存是否存在
     * @date 2022/4/8
     * @param $key
     * @return bool
     * @author litong
     */
    public static function exists($key) {
        return null !== self::get($key);
    }

    /**
     * 缓存数据encode
     * @date 2022/4/8
     * @param $data
     * @param $ttl
     * @return string
     * @author litong
     */
    private static function dataEncode($data, $ttl) {
        return serialize(["data" => $data, "ttl" => ($ttl > 0 ? time() + $ttl : 0)]);
    }

    /**
     * 缓存数据decode
     * @date 2022/4/8
     * @param $encodeData
     * @return mixed
     * @author litong
     */
    private static function dataDecode($encodeData) {
        return unserialize($encodeData);
    }

    /**
     * 获取缓存保存路径
     * @date 2022/4/8
     * @param $key
     * @return string
     * @throws \Exception
     * @author litong
     */
    private static function mkKeyPath($key) {
        $cacheKey = md5($key);
        return self::getCachePath() .
            DIRECTORY_SEPARATOR . substr($cacheKey, 0, 2) .
            DIRECTORY_SEPARATOR . substr($cacheKey, 2, 2) .
            DIRECTORY_SEPARATOR . substr($cacheKey, 4, 2) .
            DIRECTORY_SEPARATOR . $cacheKey;
    }

    /**
     * 创建缓存目录
     * @date 2022/4/8
     * @param $dir
     * @return bool
     * @author litong
     */
    private static function mkDir($dir) {
        if (!is_dir($dir)) {
            return mkdir($dir, 0755, true);
        } else {
            return true;
        }
    }

    /**
     * 获取缓存根目录
     * @date 2022/4/8
     * @return string
     * @throws \Exception
     * @author litong
     */
    private static function getCachePath() {
        if (null === self::$cachePath) {
            throw new \Exception("请执行 init 初始化", 2001);
        }
        return rtrim(self::$cachePath, DIRECTORY_SEPARATOR);
    }

    /**
     * 校验缓存可用
     * @date 2022/4/8
     * @return void
     * @throws \Exception
     * @author litong
     */
    private static function checkCachePath() {
        $path = self::getCachePath();
        if (!is_dir($path)) {
            throw new \Exception("缓存目录不存在", 2002);
        }
        if (!is_writable($path)) {
            throw new \Exception("缓存目录不可写", 2003);
        }
    }

}