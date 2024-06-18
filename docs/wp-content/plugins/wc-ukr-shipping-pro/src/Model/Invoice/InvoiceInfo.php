<?php

namespace kirillbdev\WCUkrShipping\Model\Invoice;

use kirillbdev\WCUkrShipping\Model\Invoice\Parameters\InvoiceParameters;

if ( ! defined('ABSPATH')) {
    exit;
}

class InvoiceInfo
{
    /**
     * @var string
     */
    private $payerType;

    /**
     * @var string
     */
    private $paymentMethod;

    /**
     * @var float
     */
    private $cost;

    /**
     * @var string
     */
    private $date;

    /**
     * @var string
     */
    private $cargoType;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $barcode;

    /**
     * @var string
     */
    private $additional;

    /**
     * @var InvoiceParameters
     */
    private $parameters;

    public function __construct(
        $parameters,
        $payerType,
        $paymentMethod,
        $cost,
        $date,
        $cargoType,
        $description,
        $barcode = '',
        $additional = ''
    ) {
        $this->parameters = $parameters;
        $this->payerType = $payerType;
        $this->paymentMethod = $paymentMethod;
        $this->cost = (float)$cost;
        $this->date = $date;
        $this->cargoType = $cargoType;
        $this->description = $description;
        $this->barcode = $barcode;
        $this->additional = $additional;
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