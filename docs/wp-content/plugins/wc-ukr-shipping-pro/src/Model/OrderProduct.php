<?php

namespace kirillbdev\WCUkrShipping\Model;

if ( ! defined('ABSPATH')) {
    exit;
}

class OrderProduct
{
    /**
     * @var \WC_Product
     */
    private $wcProduct;

    /**
     * @var int
     */
    private $quantity = 0;

    /**
     * OrderProduct constructor.
     *
     * @param \WC_Product $wcProduct
     * @param int $quantity
     */
    public function __construct($wcProduct, $quantity)
    {
        $this->wcProduct = $wcProduct;
        $this->quantity = (int)$quantity;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->wcProduct->get_id();
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        $weight = $this->convertWeight((float)$this->wcProduct->get_weight());

        return apply_filters('wcus_order_product_weight', $weight, $this);
    }

    /**
     * @return float
     */
    public function getWidth()
    {
        $width = $this->convertDimension((float)$this->wcProduct->get_width());

        return apply_filters('wcus_order_product_width', $width, $this);
    }

    /**
     * @return float
     */
    public function getHeight()
    {
        $height = $this->convertDimension((float)$this->wcProduct->get_height());

        return apply_filters('wcus_order_product_height', $height, $this);
    }

    /**
     * @return float
     */
    public function getLength()
    {
        $length = $this->convertDimension((float)$this->wcProduct->get_length());

        return apply_filters('wcus_order_product_length', $length, $this);
    }

    /**
     * Get product volume in m3
     *
     * @return float
     */
    public function getVolume()
    {
        $volume = $this->getWidth() * $this->getHeight() * $this->getLength() / 1000000;

        return apply_filters('wcus_order_product_volume', $volume, $this);
    }

    /**
     * @return float
     */
    public function getQuantity()
    {
        return apply_filters('wcus_order_product_quantity', $this->quantity, $this);
    }

    /**
     * @param float $weight
     *
     * @return float
     */
    private function convertWeight($weight)
    {
        $unit = get_option('woocommerce_weight_unit', 'kg');

        switch ($unit) {
            case 'g':
                return $weight / 1000;
            default:
                return $weight;
        }
    }

    /**
     * @param float $dimension
     *
     * @return float
     */
    private function convertDimension($dimension)
    {
        $unit = get_option('woocommerce_dimension_unit', 'cm');

        switch ($unit) {
            case 'm':
                return $dimension * 100;
            case 'mm':
                return $dimension / 100;
            default:
                return $dimension;
        }
    }
}