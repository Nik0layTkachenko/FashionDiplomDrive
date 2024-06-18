<?php

namespace kirillbdev\WCUkrShipping\Contracts;

if ( ! defined('ABSPATH')) {
    exit;
}

interface LoggerInterface
{
    /**
     * @param string|array $message
     * @param string $level
     * @param string|null $source
     * @param string|null $context
     *
     * @return void
     */
    public function log($message, $source, $level = 'INFO', $context = null);
}