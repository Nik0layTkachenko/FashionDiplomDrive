<?php

namespace kirillbdev\WCUkrShipping\Traits;

use kirillbdev\WCUkrShipping\Model\TTNFormData;

if ( ! defined('ABSPATH')) {
    exit;
}

trait RecipientDoorsCollector
{
    /**
     * @param TTNFormData $data
     */
    protected function collectRecipientData($data)
    {
        $type = $data->getRecipientData('type');
        $fullName = $data->getRecipientLastname() . ' ' . $data->getRecipientFirstname() . ' ' . $data->getRecipientMiddlename();

        if ('private_person' === $type) {
            $this->data['RecipientName'] = $fullName;
            $this->data['RecipientType'] = 'PrivatePerson';
        }
        else {
            $this->data['RecipientName'] = $data->getRecipientData('organization_name');
            $this->data['OwnershipForm'] = $data->getRecipientData('organization_ownership_form');
            $this->data['RecipientContactName'] = $fullName;
            $this->data['EDRPOU'] = $data->getRecipientData('edrpou');
            $this->data['RecipientType'] = 'Organization';
        }

        $this->data['RecipientCityName'] = $data->getRecipientSettlementName();
        $this->data['RecipientArea'] = $data->getRecipientSettlementArea();
        $this->data['RecipientAreaRegions'] = $data->getRecipientSettlementRegion();
        $this->data['RecipientAddressName'] = $data->getRecipientStreet();
        $this->data['RecipientHouse'] = $data->getRecipientHouse();
        $this->data['RecipientFlat'] = $data->getRecipientFlat();
        $this->data['RecipientsPhone'] = $data->getRecipientPhone();
    }
}