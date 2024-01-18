<?php

namespace Lit\Utils;


class LiSelector
{
    private $tmpField = null;
    private $conditionData = [];
    private $sqlData = [];
    private $operatorCollection = ["=", "<>", ">", "<", ">=", "<=", "in", "not in", "like", "is"];

    /**
     * 构造函数, 通过参数创建一个查询参数
     * @date 2021/8/31
     * @param array $data
     * @throws \Exception
     * @author litong
     */
    public function __construct($data = []) {
        foreach ($data as $value) {
            $this->setCondition($value[0], $value[1], $value[2]);
        }
    }

    /**
     * 设置并构建逻辑数组,SQL
     * @date 2021/8/31
     * @param string $field
     * @param string $operator
     * @param int|string|array $value
     * @return void
     * @throws \Exception
     * @author litong
     */
    private function setCondition($field, $operator, $value) {
        if (is_null($value)) {
            return;
        }
        if (!in_array($operator, $this->operatorCollection)) {
            throw new \Exception();
        }
        if (null === $field) {
            throw new \Exception();
        }
        $this->conditionData[] = [$field, $operator, $value];
        $this->tmpField = null;
    }

    private function setSql($alias, $field, $operator, $value) {
        if ($alias) {
            $alias = $alias . "`.`";
        }
        if (is_array($value)) {
            $value = array_map("addslashes", $value);
            $this->sqlData[] = "`" . $field . "` " . $operator . " (\"" . implode("\",\"", $value) . "\")";
        } else {
            if ("null" === $value) {
                $this->sqlData[] = "`" . $alias . $field . "` " . $operator . " " . $value . "";
            } else {
                $this->sqlData[] = "`" . $alias . $field . "` " . $operator . " \"" . $value . "\"";
            }
        }
    }

    /**
     * 等于
     * @date 2021/8/31
     * @param $value
     * @return void
     * @author litong
     */
    public function equal($value) {
        $this->setCondition($this->tmpField, "=", $value);
    }

    /**
     * 不等于
     * @date 2021/8/31
     * @param $value
     * @return void
     * @author litong
     */
    public function notEqual($value) {
        $this->setCondition($this->tmpField, "<>", $value);
    }

    /**
     * 小于
     * @date 2021/8/31
     * @param $value
     * @return void
     * @author litong
     */
    public function lessThan($value) {
        $this->setCondition($this->tmpField, "<", $value);
    }

    /**
     * 大于
     * @date 2021/8/31
     * @param $value
     * @return void
     * @author litong
     */
    public function greaterThan($value) {
        $this->setCondition($this->tmpField, ">", $value);
    }

    /**
     * 小于等于
     * @date 2021/8/31
     * @param $value
     * @return void
     * @author litong
     */
    public function lessEqual($value) {
        $this->setCondition($this->tmpField, "<=", $value);
    }

    /**
     * 大于等于
     * @date 2021/8/31
     * @param $value
     * @return void
     * @author litong
     */
    public function greaterEqual($value) {
        $this->setCondition($this->tmpField, ">=", $value);
    }

    /**
     * between 包含边界
     * @date 2021/8/31
     * @param string|int $value1
     * @param string|int $value2
     * @return void
     * @author litong
     */
    public function between($value1, $value2) {
        $field = $this->tmpField;
        $this->setCondition($field, ">=", $value1);
        $this->setCondition($field, "<=", $value2);
    }

    /**
     * in操作
     * @date 2021/8/31
     * @param array $value
     * @return void
     * @author litong
     */
    public function in($value) {
        $this->setCondition($this->tmpField, "in", $value);
    }

    /**
     * not in操作
     * @date 2021/8/31
     * @param array $value
     * @return void
     * @author litong
     */
    public function notIn($value) {
        $this->setCondition($this->tmpField, "not in", $value);
    }

    /**
     * like 操作
     * @date 2022/3/19
     * @param $value
     * @return void
     * @author litong
     */
    public function like($value) {
        $this->setCondition($this->tmpField, "like", $value);
    }

    /**
     * in null 操作
     * @date 2022/3/19
     * @return void
     * @author litong
     */
    public function isNull() {
        $this->setCondition($this->tmpField, "is", "null");
    }

    /**
     * 获取条件数组
     * @date 2021/8/31
     * @param string $alias
     * @return array
     * @author litong
     */
    public function getCondition($alias = '') {
        if ($alias) {
            return array_map(function ($c) use ($alias) {
                $c[0] = $alias . '.' . $c[0];
                return $c;
            }, $this->conditionData);
        } else {
            return $this->conditionData;
        }
    }

    /**
     * 获取SQL数组
     * @date 2021/8/31
     * @param string $alias
     * @return array
     * @author litong
     */
    public function getSql($alias = '') {
        foreach ($this->conditionData as $value) {
            $this->setSql($alias, $value[0], $value[1], $value[2]);
        }
        return $this->sqlData;
    }

    /**
     * 获取所有where条件
     * @date 2023/6/7
     * @param string $alias
     * @param string $logic
     * @return string
     * @author litong
     */
    public function getWhere($alias = '', $logic = 'and') {
        $where = implode(" {$logic} ", $this->getSql($alias));
        if (!empty($where)) {
            $where = " {$logic} " . $where;
        }
        return $where;
    }

    public function __get($name) {
        $this->tmpField = $name;
        return $this;
    }
}