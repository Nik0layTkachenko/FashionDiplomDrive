<?php

namespace kirillbdev\WCUkrShipping\Services\Invoice;

use kirillbdev\WCUkrShipping\DB\Repositories\WarehouseRepository;
use kirillbdev\WCUkrShipping\Factories\ProductFactory;
use kirillbdev\WCUkrShipping\Helpers\WCUSHelper;
use kirillbdev\WCUkrShipping\Model\Invoice\BackwardDelivery;
use kirillbdev\WCUkrShipping\Model\Invoice\InvoiceInfo;
use kirillbdev\WCUkrShipping\Model\Invoice\Parameters\GlobalParameters;
use kirillbdev\WCUkrShipping\Model\Invoice\Parameters\Seat;
use kirillbdev\WCUkrShipping\Model\Invoice\Parameters\SeatParameters;
use kirillbdev\WCUkrShipping\Model\OrderProduct;

if ( ! defined('ABSPATH')) {
    exit;
}

class InvoiceInfoService
{
    /**
     * @var \WC_Order
     */
    private $order;

    /**
     * @var OrderProduct[]
     */
    private $orderProducts = [];

    /**
     * @var WarehouseRepository
     */
    private $warehouseRepository;

    /**
     * InvoiceInfoService constructor.
     * @param WarehouseRepository $warehouseRepository
     */
    public function __construct($warehouseRepository)
    {
        $this->warehouseRepository = $warehouseRepository;
    }

    /**
     * @param int $orderId
     * @return InvoiceInfo
     */
    public function getInfoFromOrderId($orderId)
    {
        $this->order = wc_get_order((int)$orderId);
        $factory = new ProductFactory();

        foreach ($this->order->get_items() as $item) {
            $product = $factory->makeOrderItemProduct($item);
            $this->orderProducts[] = $product;
        }

        if ($this->needPoshtomatDelivery()) {
            $parameters = new SeatParameters([
                new Seat($this->calculateWeight(), $this->calculateWidth(), $this->calculateHeight(), $this->calculateLength())
            ]);
        }
        else {
            $parameters = new GlobalParameters(
                $this->calculateWeight(),
                $this->calculateVolumeWeight(),
                1
            );
        }

        return new InvoiceInfo(
            $parameters,
            wc_ukr_shipping_get_option('wc_ukr_shipping_np_ttn_payer_default'),
            'Cash',
            $this->order->get_subtotal() - $this->order->get_total_discount(),
            date('d.m.Y'),
            'Parcel',
            wc_ukr_shipping_get_option('wc_ukr_shipping_np_ttn_description')
        );
    }

    /**
     * @return BackwardDelivery|null
     */
    public function getBackwardDelivery()
    {
        $codPaymentId = wcus_get_option('cod_payment_id');

        if ($codPaymentId && $codPaymentId === $this->order->get_payment_method()) {
            return new BackwardDelivery(
                BackwardDelivery::$PAYER_TYPE_RECIPIENT,
                BackwardDelivery::$CARGO_TYPE_MONEY,
                ceil($this->order->get_subtotal() - $this->order->get_total_discount())
            );
        }

        return null;
    }

    /**
     * @return float
     */
    private function calculateWeight()
    {
        $weight = 0;

        foreach ($this->orderProducts as $product) {
            $weight += $product->getWeight() * $product->getQuantity();
        }

        return $weight ? round($weight, 2) : 0.1;
    }

    /**
     * @return float
     */
    private function calculateVolumeWeight()
    {
        $weight = 0;

        foreach ($this->orderProducts as $product) {
            $volume = (float)$product->getWidth() * (float)$product->getHeight() * (float)$product->getLength() / 4000;
            $weight += $volume * $product->getQuantity();
        }

        return $weight ? round($weight, 2) : 0.1;
    }

    /**
     * @return float
     */
    private function calculateWidth()
    {
        return array_reduce($this->orderProducts, function ($current, $product) {
            return $current += $product->getWidth() * $product->getQuantity();
        }, 0);
    }

    /**
     * @return float
     */
    private function calculateHeight()
    {
        return array_reduce($this->orderProducts, function ($current, $product) {
            return $current += $product->getHeight() * $product->getQuantity();
        }, 0);
    }

    /**
     * @return float
     */
    private function calculateLength()
    {
        return array_reduce($this->orderProducts, function ($current, $product) {
            return $current += $product->getLength() * $product->getQuantity();
        }, 0);
    }

    /**
     * @return bool
     */
    private function needPoshtomatDelivery()
    {
        $shipping = WCUSHelper::getOrderShippingMethod($this->order);

        if (
            $shipping
            && WC_UKR_SHIPPING_NP_SHIPPING_NAME === $shipping->get_method_id()
            && $shipping->get_meta('wcus_warehouse_ref')
        ) {
            $warehouse = $this->warehouseRepository->getWarehouseByRef($shipping->get_meta('wcus_warehouse_ref'));

            if ( ! $warehouse) {
                return false;
            }

            if (false !== strpos($warehouse->description, 'Поштомат') || false !== strpos($warehouse->description, 'Почтомат')) {
                return true;
            }
        }

        return false;
    }
}