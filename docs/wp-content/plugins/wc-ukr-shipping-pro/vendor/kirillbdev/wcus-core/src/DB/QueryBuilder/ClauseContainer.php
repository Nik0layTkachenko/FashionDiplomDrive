<?php

namespace kirillbdev\WCUSCore\DB\QueryBuilder;

if ( ! defined('ABSPATH')) {
    exit;
}

abstract class ClauseContainer
{
    /**
     * @var ClauseInterface[]
     */
    protected $clauses = [];

    /**
     * @var array
     */
    protected $bindings = [];

    /**
     * @param array $bindings
     */
    public function addBindings($bindings)
    {
        foreach ($bindings as $binding) {
            $this->bindings[] = $binding;
        }
    }
}