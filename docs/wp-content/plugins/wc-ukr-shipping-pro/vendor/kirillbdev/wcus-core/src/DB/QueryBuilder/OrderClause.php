<?php

namespace kirillbdev\WCUSCore\DB\QueryBuilder;

if ( ! defined('ABSPATH')) {
    exit;
}

class OrderClause implements ClauseInterface
{
    /**
     * @var string
     */
    private $column;

    /**
     * @var string
     */
    private $direction;

    /**
     * @param string $column
     * @param string $direction
     */
    public function __construct($column, $direction = 'asc')
    {
        $this->validateDirection($direction);
        $this->column = $column;
        $this->direction = $direction;
    }

    /**
     * @return string
     */
    public function getSql()
    {
        return "order by $this->column $this->direction";
    }

    /**
     * @return array
     */
    public function getBindings()
    {
        return [];
    }

    private function validateDirection($direction)
    {
        if ( ! in_array($direction, [ 'asc', 'desc' ])) {
            throw new \InvalidArgumentException('Invalid direction: ' . $direction);
        }
    }
}