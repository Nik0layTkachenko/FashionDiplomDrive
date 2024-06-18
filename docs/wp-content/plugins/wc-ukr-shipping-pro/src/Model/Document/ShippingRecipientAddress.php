<?php

namespace kirillbdev\WCUkrShipping\Model\Document;

use kirillbdev\WCUkrShipping\Helpers\WCUSHelper;

if ( ! defined('ABSPATH')) {
    exit;
}

class ShippingRecipientAddress
{
    /**
     * @var \WC_Order
     */
    private $order;

    /**
     * @var \WC_Order_Item_Shipping
     */
    private $orderShipping;

    /**
     * ShippingRecipientAddress constructor.
     *
     * @param $shippingMethod
     */
    public function __construct($order, $orderShipping)
    {
        $this->order = $order;
        $this->orderShipping = $orderShipping;
    }

    public function writeData(&$data)
    {
        $data['recipient']['service_type'] = $this->orderShipping->get_meta('wcus_warehouse_ref') ? 'Warehouse' : 'Doors';

        $data['recipient']['area_ref'] = $this->orderShipping->get_meta('wcus_area_ref');
        $data['recipient']['city_ref'] = $this->orderShipping->get_meta('wcus_city_ref');
        $data['recipient']['warehouse_ref'] = $this->orderShipping->get_meta('wcus_warehouse_ref');

        if ($this->orderShipping->get_meta('wcus_address')) {
            $billingOnly = 'billing_only' === get_option('woocommerce_ship_to_destination');

            $data['recipient']['custom_address'] = sprintf(
                '%s<br/>%s<br/>%s',
                $billingOnly ? $this->order->get_billing_state() : $this->order->get_shipping_state(),
                $billingOnly ? $this->order->get_billing_city() : $this->order->get_shipping_city(),
                $billingOnly ? $this->order->get_billing_address_1() : $this->order->get_shipping_address_1()
            );
        }
        else {
            $data['recipient']['custom_address'] = '';
        }

        $data['recipient']['settlement_ref'] = $this->orderShipping->get_meta('wcus_settlement_ref');
        $data['recipient']['settlement_name'] = WCUSHelper::prepareUIString($this->orderShipping->get_meta('wcus_settlement_name'));
        $data['recipient']['settlement_area'] = WCUSHelper::prepareUIString($this->orderShipping->get_meta('wcus_settlement_area'));
        $data['recipient']['settlement_region'] = WCUSHelper::prepareUIString($this->orderShipping->get_meta('wcus_settlement_region'));
        $data['recipient']['settlement_full'] = WCUSHelper::prepareUIString($this->orderShipping->get_meta('wcus_settlement_full'));
        $data['recipient']['street_full'] = WCUSHelper::prepareUIString($this->orderShipping->get_meta('wcus_street_full'));
        $data['recipient']['street_ref'] = $this->orderShipping->get_meta('wcus_street_ref');
        $data['recipient']['street_name'] = WCUSHelper::prepareUIString($this->orderShipping->get_meta('wcus_street_name'));
        $data['recipient']['house'] = $this->orderShipping->get_meta('wcus_house');
        $data['recipient']['flat'] = $this->orderShipping->get_meta('wcus_flat');
    }
}