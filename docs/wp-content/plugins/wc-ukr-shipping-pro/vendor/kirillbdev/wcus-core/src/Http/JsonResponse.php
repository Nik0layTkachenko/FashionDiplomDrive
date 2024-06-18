<?php

namespace kirillbdev\WCUSCore\Http;

use kirillbdev\WCUSCore\Http\Contracts\ResponseInterface;

if ( ! defined('ABSPATH')) {
    exit;
}

class JsonResponse implements ResponseInterface
{
    /**
     * @var array
     */
    private $data;

    /**
     * JsonResponse constructor.
     *
     * @param array $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function send()
    {
        wp_send_json($this->data);
    }
}