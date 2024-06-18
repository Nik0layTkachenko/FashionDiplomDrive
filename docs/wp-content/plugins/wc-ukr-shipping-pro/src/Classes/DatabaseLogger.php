<?php

namespace kirillbdev\WCUkrShipping\Classes;

use kirillbdev\WCUkrShipping\Contracts\LoggerInterface;
use kirillbdev\WCUkrShipping\DB\Repositories\LogRepository;

if ( ! defined('ABSPATH')) {
    exit;
}

class DatabaseLogger implements LoggerInterface
{
    /**
     * @var LogRepository
     */
    private $logRepository;

    public function __construct()
    {
        $this->logRepository = new LogRepository();
    }

    /**
     * @param string|array $message
     * @param string $level
     * @param string|null $source
     * @param string|null $context
     *
     * @return void
     */
    public function log($message, $source, $level = 'INFO', $context = null)
    {
        if ($this->hasValidLevel($level)) {
            $this->logRepository->createLog(
                $level,
                $source,
                is_array($message) ? implode('<br/>', $message) : $message,
                $context
            );
        }
    }

    private function hasValidLevel($level)
    {
        return in_array($level, [
           'INFO',
           'JOBS',
           'EXCEPTION',
           'WARNING',
           'DATABASE'
        ]);
    }
}