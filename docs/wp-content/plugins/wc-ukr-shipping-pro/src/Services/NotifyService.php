<?php

namespace kirillbdev\WCUkrShipping\Services;

use kirillbdev\WCUkrShipping\Contracts\NotificatorInterface;
use kirillbdev\WCUkrShipping\DB\TTNRepository;

if (!defined('ABSPATH')) {
    exit;
}

class NotifyService implements NotificatorInterface
{
    public function notifyUserByOrderId($orderId)
    {
        $ttnRepository = new TTNRepository();

        $mailSubject = wc_ukr_shipping_get_option('wc_ukr_shipping_np_mail_subject');
        $order = wc_get_order($orderId);
        $ttn = $ttnRepository->getTTNByOrderId($orderId);

        if ($order && $ttn) {
            do_action('wc_ukr_shipping_send_order_ttn_to_customer', $ttn, $order);

            if (apply_filters('wc_ukr_shipping_ttn_notify_enable', true)) {
                wc_mail($order->get_billing_email(), $mailSubject, $this->getTTNMailMessage($ttn, $order));
            }
        }
    }

    /**
     * @param array $ttn
     * @param \WC_Order $order
     *
     * @return mixed
     */
    private function getTTNMailMessage($ttn, $order)
    {
        $template = wp_specialchars_decode(wc_ukr_shipping_get_option('wc_ukr_shipping_np_mail_tpl'));
        $template = apply_filters('wcus_mail_template_create_ttn', $template, $ttn, $order);

        return str_replace([
            '{{ttn_number}}',
            '{{order_id}}'
        ], [
            $ttn['ttn_id'],
            $order->get_id()
        ], $template);
    }
}