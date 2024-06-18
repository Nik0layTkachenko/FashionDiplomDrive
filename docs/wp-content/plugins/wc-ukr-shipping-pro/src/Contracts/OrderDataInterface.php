<?php

namespace kirillbdev\WCUkrShipping\Contracts;

use kirillbdev\WCUkrShipping\Model\OrderProduct;

if ( ! defined('ABSPATH')) {
    exit;
}

interface OrderDataInterface
{
    /**
     * @return float
     */
    public function getSubTotal();

    /**
     * @return float
     */
    public function getDiscountTotal();

    /**
     * @return float
     */
    public function getTotal();

    /**
     * @return float
     */
    public function getCalculatedTotal();

    /**
     * @return string
     */
    public function getPaymentMethod();

    /**
     * @return AddressInterface
     */
    public function getShippingAddress();

    /**
     * @return bool
     */
    public function isAddressShipping();

    /**
     * @return bool
     */
    public function isDifferentAddressShipping();

    /**
     * @return OrderProduct[]
     */
    public function getProducts();
}