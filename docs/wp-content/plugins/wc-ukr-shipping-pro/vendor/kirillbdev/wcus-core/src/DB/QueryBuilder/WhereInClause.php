<?php

namespace kirillbdev\WCUSCore\DB\QueryBuilder;

class WhereInClause extends BaseWhereClause
{
    /**
     * WhereInClause constructor.
     * @param string $column
     * @param array $values
     */
    public function __construct($column, $values, $prefix)
    {
        parent::__construct($column, $values, 'in', $prefix);
    }

    /**
     * @return string
     */
    public function substituteValue()
    {
        $inputs = '';

        for ($i = 0; $i < count($this->value); $i++) {
            $inputs .= ($i > 0 ? ',' : '') . '%s';
        }

        return "($inputs)";
    }
}