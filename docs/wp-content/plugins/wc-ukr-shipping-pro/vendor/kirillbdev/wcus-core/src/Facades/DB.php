<?php

namespace kirillbdev\WCUSCore\Facades;

use kirillbdev\WCUSCore\DB\QueryBuilder\QueryBuilder;

if ( ! defined('ABSPATH')) {
    exit;
}

final class DB
{
    /**
     * @param string $name
     * @return QueryBuilder
     */
    public static function table($name)
    {
        return new QueryBuilder($name);
    }

    /**
     * @return string
     */
    public static function getTablePrefix()
    {
        global $wpdb;

        return $wpdb->prefix;
    }

    /**
     * @param string $name
     * @return string
     */
    public static function prefixedTable($name)
    {
        return self::getTablePrefix() . $name;
    }

    /**
     * @return string
     */
    public static function posts()
    {
        return self::prefixedTable('posts');
    }

    /**
     * @return string
     */
    public static function postmeta()
    {
        return self::prefixedTable('postmeta');
    }

    /**
     * @return string
     */
    public static function woocommerceOrderItems()
    {
        return self::prefixedTable('woocommerce_order_items');
    }
}