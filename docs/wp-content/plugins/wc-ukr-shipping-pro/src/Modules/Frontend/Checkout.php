<?php

namespace kirillbdev\WCUkrShipping\Modules\Frontend;

use kirillbdev\WCUkrShipping\Helpers\OptionsHelper;
use kirillbdev\WCUkrShipping\Services\CalculationService;
use kirillbdev\WCUkrShipping\Services\CheckoutService;
use kirillbdev\WCUSCore\Contracts\ModuleInterface;

if ( ! defined('ABSPATH')) {
    exit;
}

class Checkout implements ModuleInterface
{
    /**
     * @var CheckoutService
     */
    private $checkoutService;

    /**
     * @var CalculationService
     */
    private $calculationService;

    public function __construct()
    {
        $this->checkoutService = wcus_container_singleton('checkout_service');
        $this->calculationService = new CalculationService();
    }

    /**
     * Boot function
     *
     * @return void
     */
    public function init()
    {
        add_action($this->getInjectActionName(), [ $this, 'injectBillingFields' ]);
        add_action('woocommerce_after_checkout_shipping_form', [ $this, 'injectShippingFields' ]);
        add_filter('woocommerce_cart_shipping_method_full_label', [ $this, 'wrapShippingCost' ], 10, 2);
        add_filter('woocommerce_cart_totals_order_total_html', [ $this, 'wrapOrderTotal' ]);
        add_action( 'woocommerce_after_shipping_rate', [ $this, 'injectShippingName' ], 10, 2);
        add_filter('woocommerce_checkout_fields', [ $this, 'injectAdditionalFields' ]);
    }

    public function injectBillingFields()
    {
        $this->injectFields('billing');
    }

    public function injectShippingFields()
    {
        $this->injectFields('shipping');
    }

    public function injectAdditionalFields($fields)
    {
        if (!OptionsHelper::maybeNeedAdditionalFields()) {
            return $fields;
        }

        $middlename = [
            //'type' => 'text',
            'label' => __('Отчество', WCUS_TRANSLATE_DOMAIN),
            'class' => [
                'form-row-wide'
            ],
            'placeholder' => '',
            'required' => true,
            'priority' => 21
        ];

        $fields['billing']['wcus_billing_middlename'] = $middlename;
        $fields['shipping']['wcus_shipping_middlename'] = $middlename;

        $fields['shipping']['wcus_shipping_phone'] = [
            'type' => 'tel',
            'label' => __('Phone Number', 'woocommerce'),
            'class' => [
                'form-row-wide'
            ],
            'validate' => [
                'phone'
            ],
            'placeholder' => '',
            'required' => true,
            'priority' => 41
        ];

        return $fields;
    }

    public function wrapShippingCost($label, $method)
    {
        if ($method->get_method_id() === WC_UKR_SHIPPING_NP_SHIPPING_NAME) {
            return '<span id="wcus-shipping-cost">' . $label . '</span>';
        }

        return $label;
    }

    public function wrapOrderTotal($value)
    {
        return '<span id="wcus-order-total">' . $value . '</span>';
    }

    public function injectShippingName($method, $index)
    {
        if ($method->get_method_id() === WC_UKR_SHIPPING_NP_SHIPPING_NAME) {
            echo '<input id="wcus-shipping-name" type="hidden" value="' . esc_attr($method->get_label()) . '">';
        }
    }

    private function injectFields($type)
    {
        if (!wc_ukr_shipping_is_checkout()) {
            return;
        }

        $this->checkoutService->renderCheckoutFields($type);
    }

    private function getInjectActionName()
    {
        return 'additional' === wc_ukr_shipping_get_option('wc_ukr_shipping_np_block_pos')
            ? 'woocommerce_before_order_notes'
            : 'woocommerce_after_checkout_billing_form';
    }
}