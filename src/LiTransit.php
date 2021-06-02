<?php

namespace Lit\Utils;

/**
 * 进程内数据缓存, 用于全局数据传输, 避免污染 $GLOBALS
 * @date 2021/6/2
 * @author litong
 */
class LiTransit
{
    private static $data = [];

    /**
     * 设置缓存数据
     * @date 2021/6/2
     * @param string $key
     * @param mixed $val
     * @return bool
     * @author litong
     */
    public static function set($key, $val) {
        self::$data[$key] = $val;
        return true;
    }

    /**
     * 在不存在的时候设置缓存数据
     * @date 2021/6/2
     * @param string $key
     * @param mixed $val
     * @return bool
     * @author litong
     */
    public static function setNX($key, $val) {
        return self::exists($key) ? false : self::set($key, $val);
    }

    /**
     * 获取缓存数据
     * @date 2021/6/2
     * @param $key
     * @return mixed|null
     * @author litong
     */
    public static function get($key) {
        return self::exists($key) ? self::$data[$key] : null;
    }

    /**
     * key 是否存在
     * @date 2021/6/2
     * @param $key
     * @return bool
     * @author litong
     */
    public static function exists($key) {
        return isset(self::$data[$key]);
    }

    /**
     * 删除缓存数据
     * @date 2021/6/2
     * @param string $key
     * @return bool
     * @author litong
     */
    public static function rm($key) {
        unset(self::$data[$key]);
        return true;
    }

    /**
     * 获取所有数据
     * @date 2021/6/2
     * @return array
     * @author litong
     */
    public static function getAll() {
        return self::$data;
    }
}