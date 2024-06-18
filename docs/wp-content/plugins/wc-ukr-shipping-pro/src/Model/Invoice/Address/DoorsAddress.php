<?php

namespace kirillbdev\WCUkrShipping\Model\Invoice\Address;

if ( ! defined('ABSPATH')) {
    exit;
}

class DoorsAddress extends InvoiceAddress
{
    /**
     * @var Settlement
     */
    private $settlement;

    /**
     * @var string
     */
    private $streetName;

    /**
     * @var string
     */
    private $house;

    /**
     * @var string
     */
    private $flat;

    public function __construct($settlement, $streetName, $house, $flat)
    {
        $this->settlement = $settlement;
        $this->streetName = $streetName;
        $this->house = $house;
        $this->flat = $flat;
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
        return InvoiceAddress::$TYPE_DOORS;
    }

    public function getSettlementName()
    {
        return $this->settlement->name;
    }

    public function getSettlementArea()
    {
        return $this->settlement->area;
    }

    public function getSettlementRegion()
    {
        return $this->settlement->region;
    }
}