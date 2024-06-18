<?php
/**
 * Plugin Name: WC Ukr Shipping PRO
 * Plugin URI: https://kirillbdev.pro/wc-ukr-shipping-pro/
 * Description: Плагин доставки Украинской службой Нова Пошта для WooCommerce
 * Version: 1.9.2
 * Author: kirillbdev
 * Tested up to: 5.7
 * WC tested up to: 5.1
 * Requires at least: 5.5
 * Requires PHP: 7.0
*/

if ( ! defined('ABSPATH')) {
  exit;
}

define('WC_UKR_SHIPPING_PLUGIN_NAME', plugin_basename(__FILE__));
define('WC_UKR_SHIPPING_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WC_UKR_SHIPPING_PLUGIN_ENTRY', __FILE__);
define('WC_UKR_SHIPPING_PLUGIN_DIR', plugin_dir_path(__FILE__));

define('WCUS_PLUGIN_VERSION', '1.9.2');
define('WCUS_TRANSLATE_DOMAIN', 'wc-ukr-shipping-l10n');
define('WCUS_TRANSLATE_TYPE_PLUGIN', 0);
define('WCUS_TRANSLATE_TYPE_MO_FILE', 1);

define('WC_UKR_SHIPPING_NP_SHIPPING_NAME', 'nova_poshta_shipping');
define('WC_UKR_SHIPPING_NP_SHIPPING_TITLE', 'Доставка службой "Новая почта"');

include_once __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/globals.php';

kirillbdev\WCUkrShipping\Classes\WCUkrShipping::instance()->init();