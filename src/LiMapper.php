<?php

namespace Lit\Utils;

/**
 * @deprecated 此包已经不在维护, 新版本已经合并入 lit/parameter v2 版本
 * 注意: v2版本不向前兼容
 * github https://github.com/ghostong/LitParameter
 * packagist https://packagist.org/packages/lit/parameter
 * composer require lit/parameter
 */
class LiMapper
{

    private $updateData = [];

    /**
     * 构造函数, 通过参数创建Mapper
     * @date 2021/1/5
     * @param array $data 实例化属性
     */
    public function __construct($data = []) {
        if (!empty($data)) {
            foreach ($data as $name => $value) {
                $this->__set($name, $value);
            }
        }
    }

    /**
     * 属性转数组
     * @date 2021/1/5
     * @return array
     */
    public function __toArray() {
        try {
            $ret = [];
            $rc = new \ReflectionClass($this);
            $props = $rc->getProperties(\ReflectionProperty::IS_PROTECTED);
            foreach ($props as $prop) {
                $name = $prop->getName();
                $ret[$name] = $this->$name;
            }
            return $ret;
        } catch (\ReflectionException $e) {
            return [];
        }
    }

    public function __set($name, $value) {
        if (property_exists($this, $name)) {
            $this->$name = $value;
            $this->updateData[$name] = $value;
        }
    }

    public function __get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            return null;
        }
    }

    public function __isset($name) {
        return isset($this->$name);
    }

    /**
     * @deprecated use getUpdate
     */
    public function update() {
        return $this->updateData;
    }

    /**
     * @deprecated use getInsert
     */
    public function insert() {
        return $this->__toArray();
    }

    /**
     * 获取更新数据
     * @date 2021/1/5
     * @return array
     */
    public function getUpdate() {
        return $this->updateData;
    }

    /**
     * 获取写入数据
     * @date 2021/1/5
     * @return array
     */
    public function getInsert() {
        return $this->__toArray();
    }

}