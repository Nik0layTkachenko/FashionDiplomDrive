<?php

namespace kirillbdev\WCUkrShipping\DB\Migrations;

use kirillbdev\WCUSCore\DB\Migration;

if ( ! defined('ABSPATH')) {
    exit;
}

class CreateTTNTable extends Migration
{
    /**
     * @return string
     */
    public function name()
    {
        return 'create_ttn_table';
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
            CREATE TABLE IF NOT EXISTS wc_ukr_shipping_np_ttn (
              id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
              order_id INT(10) NOT NULL DEFAULT 0,
              ttn_id VARCHAR(255) NOT NULL,
              ttn_ref VARCHAR(255) NOT NULL,
              `status` VARCHAR (255),
              status_code VARCHAR (255),
              created_at TIMESTAMP NULL DEFAULT NULL,
              updated_at TIMESTAMP NULL DEFAULT NULL,
              PRIMARY KEY (id)
          ) $collate
        ");
    }
}