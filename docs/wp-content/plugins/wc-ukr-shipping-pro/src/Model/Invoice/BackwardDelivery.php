<?php

namespace kirillbdev\WCUkrShipping\Model\Invoice;

if ( ! defined('ABSPATH')) {
    exit;
}

class BackwardDelivery
{
    public static $PAYER_TYPE_SENDER = 'Sender';
    public static $PAYER_TYPE_RECIPIENT = 'Recipient';
    public static $CARGO_TYPE_MONEY = 'Money';

    /**
     * @var string
     */
    private $payerType;

    /**
     * @var string
     */
    private $cargoType;

    /**
     * @var int
     */
    private $cost;

    /**
     * BackwardDelivery constructor.
     * @param string $payerType
     * @param string $cargoType
     * @param int $cost
     */
    public function __construct($payerType, $cargoType, $cost)
    {
        $this->payerType = $payerType;
        $this->cargoType = $cargoType;
        $this->cost = (int)$cost;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->$name;
    }
}