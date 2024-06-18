<?php

namespace kirillbdev\WCUkrShipping\DB\Migrations;

use kirillbdev\WCUSCore\DB\Migration;

if ( ! defined('ABSPATH')) {
    exit;
}

class CreateAreasTable extends Migration
{
    /**
     * @return string
     */
    public function name()
    {
        return 'create_areas_table';
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
          CREATE TABLE IF NOT EXISTS wc_ukr_shipping_np_areas (
            ref VARCHAR(36) NOT NULL,
            description VARCHAR(255) NOT NULL
          ) $collate
        ");
    }
}