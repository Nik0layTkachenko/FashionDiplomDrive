<?php

namespace kirillbdev\WCUkrShipping\Modules\Core;

use kirillbdev\WCUSCore\Contracts\ModuleInterface;

if ( ! defined('ABSPATH')) {
    exit;
}

class Localization implements ModuleInterface
{
    /**
     * Boot function
     *
     * @return void
     */
    public function init()
    {
        add_action('plugins_loaded', [ $this, 'loadPluginTextDomain' ]);
    }

    public function loadPluginTextDomain()
    {
        load_plugin_textdomain(WCUS_TRANSLATE_DOMAIN, false, 'wc-ukr-shipping-pro/lang');
    }
}