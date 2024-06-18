<?php

namespace kirillbdev\WCUkrShipping\Foundation\Dependencies;

use kirillbdev\WCUkrShipping\Classes\WpDBCache;
use kirillbdev\WCUkrShipping\Contracts\CacheInterface;

if ( ! defined('ABSPATH')) {
    exit;
}

final class Contracts
{
    /**
     * @return array
     */
    public static function getDependencies()
    {
        return [
            CacheInterface::class => function ($container) {
                return new WpDBCache();
            }
        ];
    }
}