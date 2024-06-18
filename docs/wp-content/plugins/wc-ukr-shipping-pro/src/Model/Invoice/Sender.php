<?php

namespace kirillbdev\WCUkrShipping\Model\Invoice;

use kirillbdev\WCUkrShipping\Model\Invoice\Address\InvoiceAddress;

if ( ! defined('ABSPATH')) {
    exit;
}

class Sender
{
    /**
     * @var string
     */
    public $ref;

    /**
     * @var string
     */
    public $contactRef;

    /**
     * @var string
     */
    public $firstname;

    /**
     * @var string
     */
    public $lastname;

    /**
     * @var string
     */
    public $middlename;

    /**
     * @var string
     */
    public $phone;

    /**
     * @var InvoiceAddress
     */
    public $address;

    /**
     * Sender constructor.
     * @param string $ref
     * @param string $contactRef
     * @param InvoiceAddress
     */
    public function __construct($ref, $contactRef, $address)
    {
        $this->ref = $ref;
        $this->contactRef = $contactRef;
        $this->address = $address;
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