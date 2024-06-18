<?php

namespace kirillbdev\WCUkrShipping\Contracts;

if ( ! defined('ABSPATH')) {
    exit;
}

interface AddressInterface
{
    /**
     * @return string
     */
    public function getAreaRef();

    /**
     * @return string
     */
    public function getCityRef();

    /**
     * @return string
     */
    public function getWarehouseRef();

    /**
     * @return bool
     */
    public function isAddressShipping();

    /**
     * @return string
     */
    public function getCustomAddress();

    /**
     * @param string $key
     *
     * @return string
     */
    public function getSettlementInfo($key);

    /**
     * @param string $key
     *
     * @return string
     */
    public function getStreetInfo($key);

    /**
     * @return string
     */
    public function getHouse();

    /**
     * @return string
     */
    public function getFlat();
}