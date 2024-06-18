<?php

namespace kirillbdev\WCUkrShipping\DB\Repositories;

use kirillbdev\WCUSCore\Facades\DB;

if ( ! defined('ABSPATH')) {
    exit;
}

class OrderRepository
{
    /**
     * @return array
     */
    public function getOrdersWithTTN($offset, $limit)
    {
        return DB::table(DB::posts() . ' as p')
            ->leftJoin('wc_ukr_shipping_np_ttn as ttn', 'p.ID = ttn.order_id')
            ->where('p.post_type', 'shop_order')
            ->where('p.post_status', '!=', 'trash')
            ->orderBy('p.ID', 'desc')
            ->skip($offset)
            ->limit($limit)
            ->get([
                'p.ID as id',
                'p.post_date as created_at',
                'p.post_status',
                'ttn.ttn_id',
                'ttn.id as ttn_db_id',
                'ttn.ttn_ref'
            ]);
    }

    /**
     * @param int $orderId
     * @return array
     */
    public function getOrderInfo($orderId)
    {
        return DB::table(DB::postmeta())
            ->where('post_id', (int)$orderId)
            ->whereIn('meta_key', [
                '_billing_last_name',
                '_billing_first_name',
                '_order_total'
            ])
            ->get([
                'meta_key',
                'meta_value'
            ]);
    }

    /**
     * @param int $orderId
     * @return \stdClass|null
     */
    public function getOrderShippingMethod($orderId)
    {
        return DB::table(DB::woocommerceOrderItems())
            ->where('order_id', (int)$orderId)
            ->where('order_item_type', 'shipping')
            ->first([
                'order_item_name'
            ]);
    }

    /**
     * @param int $limit
     */
    public function getCountOrderPages($limit)
    {
        $pageCount = DB::table(DB::posts() . ' as p')
            ->where('p.post_type', 'shop_order')
            ->where('p.post_status', '!=', 'trash')
            ->count('p.ID');

        return ceil($pageCount / $limit);
    }
}