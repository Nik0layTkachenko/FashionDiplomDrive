<?php

namespace kirillbdev\WCUkrShipping\Factories;

use kirillbdev\WCUkrShipping\Model\OrderProduct;

if ( ! defined('ABSPATH')) {
    exit;
}

class ProductFactory
{
    /**
     * @param array $item
     *
     * @return OrderProduct|null
     */
    public function makeCartItemProduct($item)
    {
        $wcProduct = wc_get_product(empty($item['variation_id'])
            ? $item['product_id']
            : $item['variation_id']
        );

        if ( ! $wcProduct) {
            return null;
        }

        $product = new OrderProduct($wcProduct, $item['quantity']);

        return $product;
    }

    /**
     * @param \WC_Order_Item_Product $item
     *
     * @return OrderProduct|null
     */
    public function makeOrderItemProduct($item)
    {
        return new OrderProduct($item->get_product(), $item->get_quantity());
    }
}