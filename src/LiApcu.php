<?php

namespace Lit\Utils;

/**
 * LiApcu: APCu 用户缓存二次封装
 * @author  litong
 * @since   dev
 */
class LiApcu
{
    private static $isInit = false;
    private static $maxValueSize = 0;

    /**
     * 初始化 APCu
     * 通过 ini_set 初始化 APCu 相关配置, 并验证 APCu 扩展是否可用.
     * 注意: 部分 apc.* 配置属于 PHP_INI_SYSTEM, 运行时 ini_set 可能不会生效.
     * https://www.php.net/manual/zh/apcu.configuration.php
     * @date 2026/7/7
     * @param array $iniConfig APCu ini 配置, 如 array("apc.shm_size" => "128M", "max_value_size" => "2M")
     * @return void
     * @throws \Exception
     * @author litong
     */
    public static function init($iniConfig = array()) {
        $defaultIniConfig = array(
            "apc.enabled" => "1", // 是否启用 APCu 扩展
            "apc.enable_cli" => "1", // 是否在 CLI 模式下启用 APCu, 命令行脚本需要缓存时必须开启
            "apc.shm_size" => "128M", // APCu 共享内存总量, 用于保存所有用户缓存数据
            "apc.entries_hint" => "4096", // 预估缓存条目数量, APCu 会据此优化内部哈希表大小
            "apc.ttl" => "0", // 缓存条目默认存活秒数, 0 表示由写入时的 ttl 控制或不过期
            "apc.gc_ttl" => "3600", // 垃圾回收保留时间, 过期条目在此时间后可被清理
            "max_value_size" => "2M", // LiApcu 自定义配置, 限制单个缓存值序列化后的最大字节数, 0 表示不限制
        );

        $config = array_merge($defaultIniConfig, $iniConfig);
        self::$maxValueSize = self::sizeToBytes($config["max_value_size"]);
        unset($config["max_value_size"]);

        foreach ($config as $name => $value) {
            if ($value !== null) {
                ini_set($name, (string)$value);
            }
        }

        if (!extension_loaded("apcu")) {
            throw new \Exception("APCu 扩展未安装", 2101);
        }

        if (function_exists("apcu_enabled") && !apcu_enabled()) {
            throw new \Exception("APCu 扩展未启用", 2102);
        }

        self::$isInit = true;
    }

    /**
     * 添加缓存
     * 仅当 key 不存在时写入, 已存在则返回 false.
     * @date 2026/7/7
     * @param string $key 缓存键
     * @param mixed $value 缓存值
     * @param int $ttl 过期秒数, 0 表示不过期
     * @return bool
     * @throws \Exception
     * @author litong
     */
    public static function add($key, $value, $ttl = 0) {
        self::checkInit();
        self::checkValueSize($value);
        return apcu_add($key, $value, $ttl);
    }

    /**
     * 设置缓存
     * key 不存在时新增, 已存在时覆盖.
     * @date 2026/7/7
     * @param string|array $key 缓存键, 或 key => value 的数组
     * @param mixed $value 缓存值
     * @param int $ttl 过期秒数, 0 表示不过期
     * @return bool|array
     * @throws \Exception
     * @author litong
     */
    public static function set($key, $value = null, $ttl = 0) {
        self::checkInit();
        if (is_array($key)) {
            foreach ($key as $itemValue) {
                self::checkValueSize($itemValue);
            }
        } else {
            self::checkValueSize($value);
        }
        return apcu_store($key, $value, $ttl);
    }

    /**
     * 获取缓存
     * 第二个参数会返回是否读取成功, 用于区分 false 值和缓存不存在.
     * @date 2026/7/7
     * @param string|array $key 缓存键, 或缓存键数组
     * @param bool $success 是否读取成功
     * @return mixed
     * @throws \Exception
     * @author litong
     */
    public static function get($key, &$success = null) {
        self::checkInit();
        return apcu_fetch($key, $success);
    }

    /**
     * 删除缓存
     * 支持删除单个 key、多个 key, 或 APCUIterator 匹配到的 key.
     * @date 2026/7/7
     * @param string|array|\APCUIterator $key 缓存键
     * @return bool|array
     * @throws \Exception
     * @author litong
     */
    public static function del($key) {
        self::checkInit();
        return apcu_delete($key);
    }

    /**
     * 判断缓存是否存在
     * @date 2026/7/7
     * @param string|array $key 缓存键, 或缓存键数组
     * @return bool|array
     * @throws \Exception
     * @author litong
     */
    public static function exists($key) {
        self::checkInit();
        return apcu_exists($key);
    }

    /**
     * 自增缓存值
     * 适合计数器场景, key 不存在时 APCu 会按扩展规则初始化.
     * @date 2026/7/7
     * @param string $key 缓存键
     * @param int $step 自增步长
     * @param bool $success 是否操作成功
     * @param int $ttl key 初始化时的过期秒数
     * @return int|false
     * @throws \Exception
     * @author litong
     */
    public static function inc($key, $step = 1, &$success = null, $ttl = 0) {
        self::checkInit();
        if (self::functionParameterCount("apcu_inc") >= 4) {
            return apcu_inc($key, $step, $success, $ttl);
        }
        return apcu_inc($key, $step, $success);
    }

    /**
     * 自减缓存值
     * 适合计数器场景, key 不存在时 APCu 会按扩展规则初始化.
     * @date 2026/7/7
     * @param string $key 缓存键
     * @param int $step 自减步长
     * @param bool $success 是否操作成功
     * @param int $ttl key 初始化时的过期秒数
     * @return int|false
     * @throws \Exception
     * @author litong
     */
    public static function dec($key, $step = 1, &$success = null, $ttl = 0) {
        self::checkInit();
        if (self::functionParameterCount("apcu_dec") >= 4) {
            return apcu_dec($key, $step, $success, $ttl);
        }
        return apcu_dec($key, $step, $success);
    }

    /**
     * 比较并交换缓存值
     * 仅当当前值等于 oldValue 时, 才将其替换为 newValue.
     * @date 2026/7/7
     * @param string $key 缓存键
     * @param int $oldValue 期望的旧值
     * @param int $newValue 要写入的新值
     * @return bool
     * @throws \Exception
     * @author litong
     */
    public static function cas($key, $oldValue, $newValue) {
        self::checkInit();
        return apcu_cas($key, $oldValue, $newValue);
    }

    /**
     * 获取并设置缓存
     * key 不存在时执行回调并保存回调结果, key 存在时直接返回缓存值.
     * @date 2026/7/7
     * @param string $key 缓存键
     * @param callable $generator 缓存不存在时的数据生成函数
     * @param int $ttl 过期秒数, 0 表示不过期
     * @return mixed
     * @throws \Exception
     * @author litong
     */
    public static function remember($key, $generator, $ttl = 0) {
        self::checkInit();
        if (!function_exists("apcu_entry")) {
            $success = false;
            $value = self::get($key, $success);
            if ($success) {
                return $value;
            }
            $value = call_user_func($generator, $key);
            self::checkValueSize($value);
            self::set($key, $value, $ttl);
            return $value;
        }
        return apcu_entry($key, function ($entryKey) use ($generator) {
            $value = call_user_func($generator, $entryKey);
            self::checkValueSize($value);
            return $value;
        }, $ttl);
    }

    /**
     * 清空 APCu 用户缓存
     * @date 2026/7/7
     * @return bool
     * @throws \Exception
     * @author litong
     */
    public static function clear() {
        self::checkInit();
        return apcu_clear_cache();
    }

    /**
     * 获取缓存信息
     * 返回 APCu 命中率、缓存条目等状态信息.
     * @date 2026/7/7
     * @param bool $limited 是否返回精简信息
     * @return array|false
     * @throws \Exception
     * @author litong
     */
    public static function cacheInfo($limited = false) {
        self::checkInit();
        return apcu_cache_info($limited);
    }

    /**
     * 获取共享内存信息
     * 可用于观察 APCu 内存分配和剩余空间.
     * @date 2026/7/7
     * @param bool $limited 是否返回精简信息
     * @return array|false
     * @throws \Exception
     * @author litong
     */
    public static function smaInfo($limited = false) {
        self::checkInit();
        return apcu_sma_info($limited);
    }

    /**
     * 获取指定 key 的缓存信息
     * @date 2026/7/7
     * @param string $key 缓存键
     * @return array|null
     * @throws \Exception
     * @author litong
     */
    public static function keyInfo($key) {
        self::checkInit();
        if (!function_exists("apcu_key_info")) {
            throw new \Exception("当前 APCu 版本不支持 apcu_key_info", 2104);
        }
        return apcu_key_info($key);
    }

    /**
     * 检查 APCu 是否已经初始化
     * @date 2026/7/7
     * @return void
     * @throws \Exception
     * @author litong
     */
    private static function checkInit() {
        if (!self::$isInit) {
            throw new \Exception("请执行 init 初始化", 2103);
        }
    }

    /**
     * 检查单个缓存值大小
     * max_value_size 大于 0 时启用, 超出限制会抛出异常.
     * @date 2026/7/7
     * @param mixed $value 缓存值
     * @return void
     * @throws \Exception
     * @author litong
     */
    private static function checkValueSize($value) {
        if (self::$maxValueSize <= 0) {
            return;
        }
        $size = strlen(serialize($value));
        if ($size > self::$maxValueSize) {
            throw new \Exception("缓存值超过最大限制", 2105);
        }
    }

    /**
     * 将内存配置转换为字节数
     * 支持 128M、1G、512K 或纯数字字节.
     * @date 2026/7/7
     * @param string|int $size 内存配置
     * @return int
     * @author litong
     */
    private static function sizeToBytes($size) {
        if (is_numeric($size)) {
            return (int)$size;
        }
        $size = trim((string)$size);
        $unit = strtolower(substr($size, -1));
        $value = (float)$size;
        switch ($unit) {
            case "g":
                $value *= 1024;
            case "m":
                $value *= 1024;
            case "k":
                $value *= 1024;
        }
        return (int)$value;
    }

    /**
     * 获取函数参数数量
     * 用于兼容不同 APCu 版本的函数签名差异.
     * @date 2026/7/7
     * @param string $functionName 函数名称
     * @return int
     * @author litong
     */
    private static function functionParameterCount($functionName) {
        if (!function_exists($functionName)) {
            return 0;
        }
        $ref = new \ReflectionFunction($functionName);
        return $ref->getNumberOfParameters();
    }
}
