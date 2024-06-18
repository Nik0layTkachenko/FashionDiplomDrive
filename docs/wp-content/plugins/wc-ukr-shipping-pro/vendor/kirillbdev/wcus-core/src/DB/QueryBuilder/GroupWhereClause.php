<?php

namespace kirillbdev\WCUSCore\DB\QueryBuilder;

if ( ! defined('ABSPATH')) {
    exit;
}

class GroupWhereClause implements ClauseInterface
{
    /**
     * @var array
     */
    private $groups = [];

    /**
     * @var array
     */
    private $bindings = [];

    public function whereLike($column, $value)
    {
        $this->addGroup($column, 'like');
        $this->addBinding($value);

        return $this;
    }

    public function orWhereLike($column, $value)
    {
        $this->addGroup($column, 'like', ' or ');
        $this->addBinding($value);

        return $this;
    }

    public function getSql()
    {
        if ( ! $this->groups) {
            return '';
        }

        $sql = 'and (';

        foreach ($this->groups as $index => $group) {
            if ($index > 0) {
                $sql .= ' ';
            }

            $sql .= $group['prefix'] . $group['column'] . ' ' . $group['operator'] . ' %s';
        }

        $sql .= ')';

        return $sql;
    }

    public function getBindings()
    {
        return $this->bindings;
    }

    private function addGroup($column, $operator, $prefix = '')
    {
        $this->groups[] = [
            'column' => $column,
            'operator' => $operator,
            'prefix' => $prefix
        ];
    }

    private function addBinding($value)
    {
        $this->bindings[] = $value;
    }
}