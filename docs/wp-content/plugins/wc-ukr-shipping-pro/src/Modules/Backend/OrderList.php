<?php

namespace kirillbdev\WCUkrShipping\Modules\Backend;

use kirillbdev\WCUkrShipping\Http\Controllers\OrdersController;
use kirillbdev\WCUSCore\Contracts\ModuleInterface;
use kirillbdev\WCUSCore\Http\Routing\Route;

if ( ! defined('ABSPATH')) {
    exit;
}

class OrderList implements ModuleInterface
{
    /**
     * Boot function
     *
     * @return void
     */
    public function init()
    {
        // TODO: Implement init() method.
    }

    /**
     * @return Route[]
     */
    public function routes()
    {
        return [
            new Route('wcus_orders_list', OrdersController::class, 'getOrders'),
            new Route('wcus_generate_ttn', OrdersController::class, 'generateTTN'),
            new Route('wcus_ttn_delete', OrdersController::class, 'deleteTTN')
        ];
    }
}