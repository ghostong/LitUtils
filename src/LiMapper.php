<?php

namespace Lit\Utils;


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
        if (isset($this->$name)) {
            $this->$name = $value;
            $this->updateData[$name] = $value;
        }
    }

    public function __get($name) {
        if (isset($this->$name)) {
            return $this->$name;
        } else {
            return null;
        }
    }

    public function __isset($name) {
        return isset($this->$name);
    }

    public function update() {
        return $this->updateData;
    }

    /**
     * 获取更新数据
     * @date 2021/1/5
     * @return array
     */
    public function getUpdate() {
        return $this->update();
    }

    public function insert() {
        return $this->__toArray();
    }

    /**
     * 获取写入数据
     * @date 2021/1/5
     * @return array
     */
    public function getInsert() {
        return $this->insert();
    }

}