<?php

namespace kirillbdev\WCUSCore\DB\QueryBuilder;

class WhereClause extends BaseWhereClause
{
    public function __construct($column, $operator, $value, $prefix)
    {
        if ( ! $value) {
            parent::__construct($column, $operator, '=', $prefix);
        }
        else {
            parent::__construct($column, $value, $operator, $prefix);
        }

        if ('!=' === $this->operator) {
            $this->operator = '<>';
        }
    }

    public function substituteValue()
    {
        return '%s';
    }
}