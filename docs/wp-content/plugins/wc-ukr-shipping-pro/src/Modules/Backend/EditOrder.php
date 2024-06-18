<?php

namespace kirillbdev\WCUkrShipping\Modules\Backend;

use kirillbdev\WCUkrShipping\Classes\View;
use kirillbdev\WCUkrShipping\DB\TTNRepository;
use kirillbdev\WCUSCore\Contracts\ModuleInterface;

if ( ! defined('ABSPATH')) {
    exit;
}

class EditOrder implements ModuleInterface
{
    /**
     * @var TTNRepository
     */
    private $ttnRepository;

    public function __construct()
    {
        $this->ttnRepository = new TTNRepository();
    }

    /**
     * Boot function
     *
     * @return void
     */
    public function init()
    {
        add_action('add_meta_boxes', [$this, 'addTTNBlockToOrderEdit']);
    }

    /**
     * Add TTN metabox to edit order page.
     */
    public function addTTNBlockToOrderEdit()
    {
        add_meta_box(
            'wcus_edit_order_ttn_metabox',
            'Экспрес-накладная',
            [$this, 'editOrderTTNMetaboxHtml'],
            'shop_order',
            'side'
        );
    }

    /**
     * Render edit order TTN metabox html.
     *
     * @param $post
     */
    public function editOrderTTNMetaboxHtml($post)
    {
        $order = wc_get_order($post->ID);

        if ( ! $order || ( ! $order->has_shipping_method(WC_UKR_SHIPPING_NP_SHIPPING_NAME) && ! (int)wcus_get_option('ttn_any_shipping'))) {
            echo __('edit_order_invalid_shipping_method', WCUS_TRANSLATE_DOMAIN);

            return;
        }

        $data['ttn'] = $this->ttnRepository->getTTNByOrderId($post->ID);
        $data['order_id'] = $post->ID;

        echo View::render('order/edit_order_metabox', $data);
    }
}