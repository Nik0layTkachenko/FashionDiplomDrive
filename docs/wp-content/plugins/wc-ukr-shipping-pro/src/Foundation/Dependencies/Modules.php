<?php

namespace kirillbdev\WCUkrShipping\Foundation\Dependencies;

use kirillbdev\WCUkrShipping\Modules\Core\Activator;
use kirillbdev\WCUSCore\DB\Migrator;

if ( ! defined('ABSPATH')) {
    exit;
}

final class Modules
{
    /**
     * @return array
     */
    public static function getDependencies()
    {
        return [
            Activator::class => function ($container) {
                return new Activator($container->make(Migrator::class));
            }
        ];
    }
}