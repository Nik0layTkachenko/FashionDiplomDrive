<?php

namespace kirillbdev\WCUSCore\Http\Contracts;

if ( ! defined('ABSPATH')) {
    exit;
}

interface ResponseInterface
{
    public function send();
}