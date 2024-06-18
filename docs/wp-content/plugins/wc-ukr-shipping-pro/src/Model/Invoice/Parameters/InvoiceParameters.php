<?php

namespace kirillbdev\WCUkrShipping\Model\Invoice\Parameters;

if ( ! defined('ABSPATH')) {
    exit;
}

abstract class InvoiceParameters
{
    public static $TYPE_GLOBAL = 0;
    public static $TYPE_SEAT = 1;

    /**
     * @return int
     */
    abstract public function getType();
}