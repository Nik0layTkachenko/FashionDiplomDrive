<?php

namespace kirillbdev\WCUkrShipping\DB\Repositories;

use kirillbdev\WCUkrShipping\Model\Invoice\Invoice;

if ( ! defined('ABSPATH')) {
    exit;
}

class InvoiceRepository
{
    /**
     * @param Invoice $invoice
     */
    public function createInvoice($invoice)
    {
        global $wpdb;

        $dateCreated = date('Y-m-d H:i:s');

        $wpdb->query("
          INSERT INTO wc_ukr_shipping_np_ttn (order_id, ttn_id, ttn_ref, status, status_code, created_at, updated_at)
          VALUES ('" . (int)$invoice->orderId . "', '{$invoice->documentNumber}', '{$invoice->ref}', 'Нова пошта очікує надходження від відправника', '1', '$dateCreated', '$dateCreated')
        ");

        return $wpdb->insert_id;
    }

    /**
     * @param string $ref
     */
    public function deleteByRef($ref)
    {
        global $wpdb;

        $wpdb->delete('wc_ukr_shipping_np_ttn', [
            'ttn_ref' => $ref
        ]);
    }
}