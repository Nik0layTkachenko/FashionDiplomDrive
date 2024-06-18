<?php

namespace kirillbdev\WCUkrShipping\Modules\Frontend;

use kirillbdev\WCUkrShipping\Model\Order\CheckoutOrderData;
use kirillbdev\WCUkrShipping\Services\CalculationService;
use kirillbdev\WCUkrShipping\Services\TranslateService;
use kirillbdev\WCUSCore\Contracts\ModuleInterface;

if ( ! defined('ABSPATH')) {
    exit;
}

class ShippingMethod implements ModuleInterface
{
    /**
     * @var TranslateService
     */
    private $translateService;

    public function __construct()
    {
        $this->translateService = wcus_container_singleton('translate_service');
    }

    /**
     * Boot function
     *
     * @return void
     */
    public function init()
    {
        add_filter('woocommerce_shipping_methods', [ $this, 'registerShippingMethod' ]);
        add_filter('woocommerce_shipping_rate_label', [ $this, 'getRateLabel' ], 10, 2);
        add_filter('woocommerce_shipping_rate_cost', [ $this, 'calculateCost' ], 10, 2);
    }

    public function registerShippingMethod($methods)
    {
        include_once WC_UKR_SHIPPING_PLUGIN_DIR . '/src/Classes/NovaPoshtaShipping.php';

        $methods[WC_UKR_SHIPPING_NP_SHIPPING_NAME] = 'NovaPoshtaShipping';

        return $methods;
    }

    public function getRateLabel($label, $rate)
    {
        if (WC_UKR_SHIPPING_NP_SHIPPING_NAME === $rate->get_method_id()) {
            $methodLabel = $this->translateService->getTranslates()['method_title'];
            $label = apply_filters('wcus_checkout_method_label', $methodLabel);
        }

        return $label;
    }

    public function calculateCost($cost, $rate)
    {
        if (WC_UKR_SHIPPING_NP_SHIPPING_NAME !== $rate->get_method_id()) {
            return $cost;
        }

        if (empty($_GET['wc-ajax']) || 'update_order_review' !== $_GET['wc-ajax'] || empty($_POST['post_data'])) {
            return 0;
        }

        parse_str($_POST['post_data'], $post);

        $orderData = new CheckoutOrderData($post);
        $calculationService = new CalculationService();
        $cost = $calculationService->calculateCost($orderData);

        if (in_array(WC_UKR_SHIPPING_NP_SHIPPING_NAME, wc_get_chosen_shipping_method_ids()) && (int)wcus_get_option('cost_view_only')) {
            wc()->cart->set_total($orderData->getCalculatedTotal());
        }

        return $cost;
    }
}