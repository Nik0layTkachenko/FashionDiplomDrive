<?php

namespace kirillbdev\WCUSCore\DB\QueryBuilder;

if ( ! defined('ABSPATH')) {
    exit;
}

abstract class BaseWhereClause implements ClauseInterface
{
    /**
     * @var string
     */
    protected $column;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var string
     */
    protected $operator;

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @param string $column
     * @param mixed $value
     * @param string $operator
     * @param string $prefix
     */
    public function __construct($column, $value, $operator = '=', $prefix = 'and')
    {
        $this->column = $column;
        $this->value = $value;
        $this->operator = $operator;
        $this->prefix = $prefix;

        $this->validateOperator();
        $this->validatePrefix();
    }

    abstract public function substituteValue();

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function getSql()
    {
        return  "$this->column $this->operator " . $this->substituteValue();
    }

    public function getBindings()
    {
        return [ $this->value ];
    }

    private function validateOperator()
    {
        if ( ! in_array($this->operator, [ '=', '!=', '>', '<', 'like', 'in' ])) {
            throw new \InvalidArgumentException('Invalid where clause operator: ' . $this->operator);
        }
    }

    private function validatePrefix()
    {
        if ( ! in_array($this->prefix, [ 'or', 'and' ])) {
            throw new \InvalidArgumentException('Invalid where clause prefix: ' . $this->prefix);
        }
    }
}