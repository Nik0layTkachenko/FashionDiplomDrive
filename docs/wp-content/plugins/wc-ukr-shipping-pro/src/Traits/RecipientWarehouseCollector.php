<?php

namespace kirillbdev\WCUkrShipping\Traits;

use kirillbdev\WCUkrShipping\Model\TTNFormData;

if ( ! defined('ABSPATH')) {
    exit;
}

trait RecipientWarehouseCollector
{
    /**
     * @param TTNFormData $data
     */
    protected function collectRecipientData($data)
    {
        $this->data['Recipient'] = $data->getValue('recipient')['ref'];
        $this->data['ContactRecipient'] = $data->getValue('recipient')['contact_ref'];
        $this->data['CityRecipient'] = $data->getRecipientCity();
        $this->data['RecipientAddress'] = $data->getRecipientAddress();
        $this->data['RecipientsPhone'] = $data->getRecipientPhone();
    }
}