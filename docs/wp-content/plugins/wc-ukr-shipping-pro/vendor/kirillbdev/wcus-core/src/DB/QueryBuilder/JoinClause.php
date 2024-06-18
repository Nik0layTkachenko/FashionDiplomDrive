<?php

namespace kirillbdev\WCUSCore\DB\QueryBuilder;

if ( ! defined('ABSPATH')) {
    exit;
}

class JoinClause implements ClauseInterface
{
    /**
     * @var string
     */
    private $type = 'inner';

    /**
     * @var string
     */
    private $table;

    /**
     * @var string
     */
    private $condition;

    public function __construct($table, $condition, $type = 'inner')
    {
        $this->table = $table;
        $this->condition = $condition;
        $this->type = in_array($type, [ 'inner', 'left', 'right' ]) ? $type : 'inner';
    }

    /**
     * @return string
     */
    public function getSql()
    {
        return "$this->type join $this->table on $this->condition";
    }

    /**
     * @return array
     */
    public function getBindings()
    {
        return [];
    }
}