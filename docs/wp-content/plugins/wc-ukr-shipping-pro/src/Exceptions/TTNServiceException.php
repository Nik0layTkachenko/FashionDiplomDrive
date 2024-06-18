<?php

namespace kirillbdev\WCUkrShipping\Exceptions;

if ( ! defined('ABSPATH')) {
    exit;
}

class TTNServiceException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}