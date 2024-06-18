<?php

namespace kirillbdev\WCUSCore\Http\Middleware;

use kirillbdev\WCUSCore\Http\Request;

if ( ! defined('ABSPATH')) {
    exit;
}

class VerifyCsrfToken
{
    /**
     * @param Request $request
     */
    public function handle($request)
    {
        if ( ! wp_verify_nonce($request->get('_token', ''), 'wc-ukr-shipping')) {
            wp_send_json([
                'success' => false
            ]);
        }
    }
}