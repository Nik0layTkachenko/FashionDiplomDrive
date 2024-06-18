<?php

namespace kirillbdev\WCUkrShipping\DB\Repositories;

use kirillbdev\WCUSCore\Facades\DB;

if ( ! defined('ABSPATH')) {
    exit;
}

class WarehouseRepository
{
    /**
     * @param string $ref
     * @return \stdClass|null
     */
    public function getWarehouseByRef($ref)
    {
        return DB::table('wc_ukr_shipping_np_warehouses')
            ->where('ref', $ref)
            ->limit(1)
            ->first();
    }
}