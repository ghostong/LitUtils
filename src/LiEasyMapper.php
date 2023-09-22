<?php

namespace Lit\Utils;

class LiEasyMapper
{
    /**
     * 构造函数快速赋值
     * @date 2023/9/22
     * @param array $data
     * @author litong
     */
    public function __construct($data = []) {
        $reflectionClass = new \ReflectionClass($this);
        foreach ($data as $name => $value) {
            if ($reflectionClass->hasProperty($name) && $reflectionClass->getProperty($name)->isPublic()) {
                $this->$name = $value;
            }
        }
    }

    /**
     * 对象转数组
     * @date 2023/9/22
     * @return array
     * @author litong
     */
    public function toArray() {
        $return = [];
        $reflectionClass = new \ReflectionClass($this);
        $properties = $reflectionClass->getProperties(\ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $property) {
            $name = $property->getName();
            $return[$name] = $this->$name;
        }
        return $return;
    }
}