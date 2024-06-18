<?php

namespace kirillbdev\WCUSCore\DB\QueryBuilder;

if ( ! defined('ABSPATH')) {
    exit;
}

class QueryBuilder
{
    private $wpdb;

    /**
     * @var string
     */
    private $table;

    /**
     * @var int
     */
    private $skip = 0;

    /**
     * @var int
     */
    private $limit = 0;

    /**
     * @var ClauseInterface[]
     */
    private $joinClauses = [];

    /**
     * @var BaseWhereClause[]
     */
    private $whereClauses = [];

    /**
     * @var ClauseInterface[]
     */
    private $clauses = [];

    /**
     * @var array
     */
    private $bindings = [];

    public function __construct($table)
    {
        global $wpdb;

        $this->wpdb = $wpdb;
        $this->table = $table;
    }

    public function join($table, $condition)
    {
        $this->joinClauses[] = new JoinClause($table, $condition);

        return $this;
    }

    public function leftJoin($table, $condition)
    {
        $this->joinClauses[] = new JoinClause($table, $condition, 'left');

        return $this;
    }

    public function rightJoin($table, $condition)
    {
        $this->joinClauses[] = new JoinClause($table, $condition, 'right');

        return $this;
    }

    /**
     * @param string $column
     * @param string $value
     * @param string $operator
     *
     * @return $this
     */
    public function where($column, $operator = null, $value = null)
    {
        $this->whereClauses[] = new WhereClause($column, $operator, $value, 'and');

        return $this;
    }

    /**
     * @param string $column
     * @param string $value
     * @param string $operator
     *
     * @return $this
     */
    public function orWhere($column, $operator = null, $value = null)
    {
        $this->whereClauses[] = new WhereClause($column, $operator, $value, 'or');

        return $this;
    }

    /**
     * @param string $column
     * @param string $value
     *
     * @return $this
     */
    public function whereLike($column, $value)
    {
        $this->clauses[] = new WhereLikeClause($column, $value);

        return $this;
    }

    /**
     * @param string $column
     * @param string $value
     *
     * @return $this
     */
    public function orWhereLike($column, $value)
    {
        $this->clauses[] = new WhereLikeClause($column, $value, 'or');

        return $this;
    }

    /**
     * @param string $column
     * @param array $values
     * @return $this
     */
    public function whereIn($column, $values)
    {
        $this->whereClauses[] = new WhereInClause($column, $values, 'and');

        return $this;
    }

    /**
     * @param string $column
     * @param array $values
     * @return $this
     */
    public function orWhereIn($column, $values)
    {
        $this->whereClauses[] = new WhereInClause($column, $values, 'or');

        return $this;
    }

    /**
     * @param string $column
     * @param string $direction
     *
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->clauses[] = new OrderClause($column, $direction);

        return $this;
    }

    /**
     * @param int $skip
     *
     * @return $this
     */
    public function skip($skip)
    {
        $this->skip = max(0, (int)$skip);

        return $this;
    }

    /**
     * @param int $limit
     *
     * @return $this
     */
    public function limit($limit)
    {
        $this->limit = max(0, (int)$limit);

        return $this;
    }

    /**
     * @param array $columns
     *
     * @return array
     */
    public function get($columns = [ '*' ])
    {
        $sql = $this->buildQuery();
        $select = 'select ' . implode(', ', $columns) . ' from ' . $this->table;
        $sql = $select . ' ' . $sql;

        return $this->wpdb->get_results(
            $this->wpdb->prepare($sql, $this->bindings),
            ARRAY_A
        );
    }

    /**
     * Fetch first row by criteria.
     *
     * @param array $columns
     * @return object|null
     */
    public function first($columns = [ '*' ])
    {
        $sql = $this->buildQuery();
        $select = 'select ' . implode(', ', $columns) . ' from ' . $this->table;
        $sql = $select . ' ' . $sql;

        return $this->wpdb->get_row(
            $this->wpdb->prepare($sql, $this->bindings)
        );
    }

    /**
     * @param string $column
     *
     * @return int
     */
    public function count($column = 'id')
    {
        $sql = $this->buildQuery();
        $select = 'select COUNT(' . sanitize_text_field($column) . ') from ' . $this->table;
        $sql = $select . ' ' . $sql;

        return (int)$this->wpdb->get_var($this->wpdb->prepare($sql, $this->bindings));
    }

    /**
     * @param array $bindings
     */
    public function addBindings($bindings)
    {
        foreach ($bindings as $binding) {
            if (is_array($binding)) {
                $this->bindings = array_merge($this->bindings, $binding);
            }
            else {
                $this->bindings[] = $binding;
            }
        }
    }

    private function buildQuery()
    {
        $sql = '';

        foreach ($this->joinClauses as $clause) {
            $sql .= ' ' . $clause->getSql();
            $this->addBindings($clause->getBindings());
        }

        $sql .= ' where';

        foreach ($this->whereClauses as $index => $clause) {
            if ($index > 0) {
                $sql .= ' ' . $clause->getPrefix() . ' ' . $clause->getSql();
            }
            else {
                $sql .= ' ' . $clause->getSql();
            }

            $this->addBindings($clause->getBindings());
        }

        foreach ($this->clauses as $clause) {
            $sql .= ' ' . $clause->getSql();
            $this->addBindings($clause->getBindings());
        }

        if ($this->limit) {
            $sql .= " limit $this->skip, $this->limit";
        }

        return $sql;
    }
}