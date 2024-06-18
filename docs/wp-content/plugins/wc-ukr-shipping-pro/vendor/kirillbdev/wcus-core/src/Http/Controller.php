<?php

namespace kirillbdev\WCUSCore\Http;

use kirillbdev\WCUSCore\Http\Contracts\ResponseInterface;

if ( ! defined('ABSPATH')) {
    exit;
}

abstract class Controller
{
    /**
     * @param array $data
     *
     * @return ResponseInterface
     */
    public function jsonResponse($data)
    {
        return new JsonResponse($data);
    }
}