<?php

namespace kirillbdev\WCUSCore\DB\QueryBuilder;

if ( ! defined('ABSPATH')) {
    exit;
}

class WhereLikeClause implements ClauseInterface
{
    /**
     * @var string
     */
    private $column;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @param string $column
     * @param string $value
     */
    public function __construct($column, $value, $prefix = '')
    {
        $this->column = $column;
        $this->value = $value;
        $this->prefix = in_array($prefix, [ 'or', 'and' ]) ? $prefix : '';
    }

    public function getSql()
    {
        if ($this->prefix) {
            return "$this->prefix $this->column like %s";
        }

        return "where $this->column like %s";
    }

    public function getBindings()
    {
        return [ $this->value ];
    }

    /**
     * @param string $operator
     */
    private function validateOperator($operator)
    {
        if ( ! in_array($operator, [ '=', '>', '<' ])) {
            throw new \InvalidArgumentException('Invalid operator: ' . $operator);
        }
    }
}