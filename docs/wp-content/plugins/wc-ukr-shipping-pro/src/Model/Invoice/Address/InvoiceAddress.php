<?php

namespace kirillbdev\WCUkrShipping\Model\Invoice\Address;

if ( ! defined('ABSPATH')) {
    exit;
}

abstract class InvoiceAddress
{
    public static $TYPE_WAREHOUSE = 'Warehouse';
    public static $TYPE_DOORS = 'Doors';

    /**
     * @return string
     */
    abstract public function getType();
}