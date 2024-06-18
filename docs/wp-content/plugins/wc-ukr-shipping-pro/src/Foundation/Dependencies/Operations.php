<?php

namespace kirillbdev\WCUkrShipping\Foundation\Dependencies;

use kirillbdev\WCUkrShipping\Services\Invoice\InvoiceInfoService;
use kirillbdev\WCUkrShipping\Services\Invoice\InvoiceService;
use kirillbdev\WCUkrShipping\Services\Invoice\RecipientService;
use kirillbdev\WCUkrShipping\Services\Invoice\SenderService;
use kirillbdev\WCUkrShipping\Operations\AutoInvoiceOperation;
use kirillbdev\WCUkrShipping\Services\NotifyService;

if ( ! defined('ABSPATH')) {
    exit;
}

final class Operations
{
    /**
     * @return array
     */
    public static function getDependencies()
    {
        return [
            AutoInvoiceOperation::class => function ($container) {
                return new AutoInvoiceOperation(
                    $container->make(SenderService::class),
                    $container->make(RecipientService::class),
                    $container->make(InvoiceService::class),
                    $container->make(InvoiceInfoService::class),
                    $container->make(NotifyService::class)
                );
            }
        ];
    }
}