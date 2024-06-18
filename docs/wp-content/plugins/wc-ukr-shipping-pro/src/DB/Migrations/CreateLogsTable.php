<?php

namespace kirillbdev\WCUkrShipping\DB\Migrations;

use kirillbdev\WCUSCore\DB\Migration;

if ( ! defined('ABSPATH')) {
    exit;
}

class CreateLogsTable extends Migration
{
    /**
     * @return string
     */
    public function name()
    {
        return 'create_logs_table';
    }

    /**
     * @param mixed $db
     *
     * @return void
     */
    public function up($db)
    {
        $collate = $db->get_charset_collate();

        $db->query("
            CREATE TABLE IF NOT EXISTS wc_ukr_shipping_logs (
              `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
              `level` VARCHAR(255) NOT NULL,
              `source` VARCHAR(255) NOT NULL,
              `message` LONGTEXT NOT NULL,
              `context` LONGTEXT NULL DEFAULT NULL,
              `created_at` TIMESTAMP NULL DEFAULT NULL,
              PRIMARY KEY (id)
          ) $collate
        ");
    }
}