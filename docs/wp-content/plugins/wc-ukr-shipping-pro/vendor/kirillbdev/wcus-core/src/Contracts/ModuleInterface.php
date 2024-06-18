<?php

namespace kirillbdev\WCUSCore\Contracts;

if ( ! defined('ABSPATH')) {
    exit;
}

interface ModuleInterface
{
    /**
     * Boot function
     *
     * @return void
     */
    public function init();
}