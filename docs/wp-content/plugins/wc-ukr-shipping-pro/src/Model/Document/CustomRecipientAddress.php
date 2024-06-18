<?php

namespace kirillbdev\WCUkrShipping\Model\Document;

if ( ! defined('ABSPATH')) {
    exit;
}

class CustomRecipientAddress
{
    /**
     * @var \WC_Order
     */
    private $order;

    /**
     * CustomRecipientAddress constructor.
     *
     * @param $order
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    public function writeData(&$data)
    {
        $data['recipient']['service_type'] = 'Warehouse';

        $data['recipient']['area_ref'] = '';
        $data['recipient']['city_ref'] = '';
        $data['recipient']['warehouse_ref'] = '';

        $billingOnly = 'billing_only' === get_option('woocommerce_ship_to_destination');

        $data['recipient']['custom_address'] = sprintf(
            '%s<br/>%s<br/>%s',
            $billingOnly ? $this->order->get_billing_state() : $this->order->get_shipping_state(),
            $billingOnly ? $this->order->get_billing_city() : $this->order->get_shipping_city(),
            $billingOnly ? $this->order->get_billing_address_1() : $this->order->get_shipping_address_1()
        );

        $data['recipient']['settlement_ref'] = '';
        $data['recipient']['settlement_name'] = '';
        $data['recipient']['settlement_area'] = '';
        $data['recipient']['settlement_region'] = '';
        $data['recipient']['settlement_full'] = '';
        $data['recipient']['street_full'] = '';
        $data['recipient']['street_ref'] = '';
        $data['recipient']['street_name'] = '';
        $data['recipient']['house'] = '';
        $data['recipient']['flat'] = '';
    }
}