<?php

namespace kirillbdev\WCUkrShipping\Model\Invoice\Address;

if ( ! defined('ABSPATH')) {
    exit;
}

class WarehouseAddress extends InvoiceAddress
{
    /**
     * @var string
     */
    private $cityRef;

    /**
     * @var string
     */
    private $warehouseRef;

    public function __construct($cityRef, $warehouseRef)
    {
        $this->cityRef = $cityRef;
        $this->warehouseRef = $warehouseRef;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return InvoiceAddress::$TYPE_WAREHOUSE;
    }
}