<?php

namespace kirillbdev\WCUkrShipping\Foundation\Dependencies;

use kirillbdev\WCUkrShipping\Contracts\CacheInterface;
use kirillbdev\WCUkrShipping\DB\OptionsRepository;
use kirillbdev\WCUkrShipping\Http\Controllers\CacheController;
use kirillbdev\WCUkrShipping\Http\Controllers\OptionsController;
use kirillbdev\WCUkrShipping\Http\Controllers\OrdersController;
use kirillbdev\WCUkrShipping\Operations\AutoInvoiceOperation;
use kirillbdev\WCUkrShipping\Services\Backend\OrderService;
use kirillbdev\WCUkrShipping\Services\Invoice\InvoiceService;

if ( ! defined('ABSPATH')) {
    exit;
}

final class Controllers
{
    /**
     * @return array
     */
    public static function getDependencies()
    {
        return [
            OptionsController::class => function ($container) {
                return new OptionsController($container->make(OptionsRepository::class));
            },
            CacheController::class => function ($container) {
                return new CacheController($container->make(CacheInterface::class));
            },
            OrdersController::class => function ($container) {
                return new OrdersController(
                    $container->make(OrderService::class),
                    $container->make(InvoiceService::class),
                    $container->make(AutoInvoiceOperation::class)
                );
            }
        ];
    }
}