<?php

namespace kirillbdev\WCUkrShipping\DB\Migrations;

use kirillbdev\WCUSCore\DB\Migration;

if ( ! defined('ABSPATH')) {
    exit;
}

class CreateIndexes extends Migration
{
    /**
     * @return string
     */
    public function name()
    {
        return 'create_indexes';
    }

    /**
     * @param mixed $db
     *
     * @return void
     */
    public function up($db)
    {
        $db->query("
          ALTER TABLE wc_ukr_shipping_np_areas
          ADD PRIMARY KEY (ref)
        ");

        $db->query("
          ALTER TABLE wc_ukr_shipping_np_cities
          ADD PRIMARY KEY (ref)
        ");

        $db->query("
          CREATE INDEX area_ref
          ON wc_ukr_shipping_np_cities(area_ref)
        ");

        $db->query("
          ALTER TABLE wc_ukr_shipping_np_warehouses
          ADD PRIMARY KEY (ref)
        ");

        $db->query("
          CREATE INDEX city_ref
          ON wc_ukr_shipping_np_warehouses(city_ref)
        ");

        $db->query("
          CREATE INDEX `number_index`
          ON wc_ukr_shipping_np_warehouses(`number`)
        ");
    }
}