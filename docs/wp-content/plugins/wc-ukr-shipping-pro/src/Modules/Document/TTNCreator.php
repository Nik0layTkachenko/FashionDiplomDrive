<?php

namespace kirillbdev\WCUkrShipping\Modules\Document;

use kirillbdev\WCUkrShipping\Http\Controllers\CounterpartyController;
use kirillbdev\WCUkrShipping\Http\Controllers\TTNController;
use kirillbdev\WCUSCore\Http\Routing\Route;
use kirillbdev\WCUSCore\Contracts\ModuleInterface;

if ( ! defined('ABSPATH')) {
    exit;
}

class TTNCreator implements ModuleInterface
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
            new Route('wcus_counterparty_create', CounterpartyController::class, 'create'),
            new Route('wcus_counterparty_contact_create', CounterpartyController::class, 'createContact'),
            new Route('wcus_counterparty_create_organization', CounterpartyController::class, 'createOrganization'),
            new Route('wcus_ttn_save', TTNController::class, 'saveTTN')
        ];
    }
}