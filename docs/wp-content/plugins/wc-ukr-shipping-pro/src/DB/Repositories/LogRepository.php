<?php

namespace kirillbdev\WCUkrShipping\DB\Repositories;

if ( ! defined('ABSPATH')) {
    exit;
}

class LogRepository
{
    // todo: refactor to repo base
    private $db;

    public function __construct()
    {
        global $wpdb;

        $this->db = $wpdb;
    }

    /**
     * @param string $level
     * @param string $source
     * @param string $message
     * @param string|null $context
     */
    public function createLog($level, $source, $message, $context = null)
    {
        $this->db->insert('wc_ukr_shipping_logs', [
            'level' => $level,
            'source' => $source,
            'message' => $message,
            'context' => $context,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function getLogs($params = [])
    {
        return $this->db->get_results("
            SELECT *
            FROM `wc_ukr_shipping_logs`
            ORDER BY `created_at` DESC
        ", ARRAY_A);
    }
}