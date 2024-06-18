<?php

namespace kirillbdev\WCUkrShipping\Model\Invoice\Parameters;

if ( ! defined('ABSPATH')) {
    exit;
}

class GlobalParameters extends InvoiceParameters
{
    /**
     * @var float
     */
    private $weight;

    /**
     * @var bool
     */
    private $volumeEnable;

    /**
     * @var float
     */
    private $volumeWeight;

    /**
     * @var int
     */
    private $seatsAmount;

    /**
     * GlobalParameters constructor.
     * @param float $weight
     * @param float $volumeWeight
     * @param int $seatsAmount
     * @param bool $volumeEnable
     */
    public function __construct($weight, $volumeWeight, $seatsAmount, $volumeEnable = false)
    {
        $this->weight = $weight;
        $this->volumeEnable = $volumeEnable;
        $this->volumeWeight = $volumeWeight;
        $this->seatsAmount = $seatsAmount;
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
     * @return int
     */
    public function getType()
    {
        return InvoiceParameters::$TYPE_GLOBAL;
    }
}