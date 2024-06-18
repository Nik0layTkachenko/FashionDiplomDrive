<?php

namespace kirillbdev\WCUkrShipping\DB\Migrations;

use kirillbdev\WCUSCore\DB\Migration;

if ( ! defined('ABSPATH')) {
    exit;
}

class CreateCitiesTable extends Migration
{
    /**
     * @return string
     */
    public function name()
    {
        return 'create_cities_table';
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
          CREATE TABLE IF NOT EXISTS wc_ukr_shipping_np_cities (
            ref VARCHAR(36) NOT NULL,
            description VARCHAR(255) NOT NULL,
            description_ru VARCHAR(255) NOT NULL,
            area_ref VARCHAR(36)
          ) $collate
        ");
    }
}