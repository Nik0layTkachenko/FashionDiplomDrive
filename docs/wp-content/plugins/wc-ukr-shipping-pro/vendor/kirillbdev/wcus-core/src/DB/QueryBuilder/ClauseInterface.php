<?php

namespace kirillbdev\WCUSCore\DB\QueryBuilder;

if ( ! defined('ABSPATH')) {
    exit;
}

interface ClauseInterface
{
    /**
     * @return string
     */
    public function getSql();

    /**
     * @return array
     */
    public function getBindings();
}