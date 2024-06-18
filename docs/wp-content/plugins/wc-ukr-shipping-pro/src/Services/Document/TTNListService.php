<?php

namespace kirillbdev\WCUkrShipping\Services\Document;

if ( ! defined('ABSPATH')) {
    exit;
}

class TTNListService
{
    /**
     * @return array
     */
    public function getTTNList()
    {
        global $wpdb;

        $results = $wpdb->get_results("
          SELECT * 
          FROM wc_ukr_shipping_np_ttn 
          ORDER BY created_at DESC
        ", ARRAY_A);

        $list = [];

        foreach ($results as $result) {
            $orderUrl = '#';
            $orderName = 'ЭН не привязана к заказу';

            if ($result['order_id']) {
                $order = wc_get_order($result['order_id']);

                if ($order) {
                    $orderUrl = $order->get_edit_order_url();
                    $orderName = sprintf('#%s %s %s',
                        $order->get_id(),
                        $order->get_billing_first_name(),
                        $order->get_billing_last_name()
                    );
                }
            }

            $list[] = [
                'id' => $result['id'],
                'ttn_id' => $result['ttn_id'],
                'order_url' => $orderUrl,
                'order_name' => $orderName,
                'order_id' => $result['order_id'],
                'status' => $result['status'],
                'created_at' => date('Y.m.d H:i:s', strtotime($result['created_at']))
            ];
        }

        return $list;
    }
}