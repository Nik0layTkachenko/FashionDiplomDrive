<?php

namespace kirillbdev\WCUkrShipping\Traits;

use kirillbdev\WCUkrShipping\Model\TTNFormData;

if ( ! defined('ABSPATH')) {
  exit;
}

trait SenderDoorsCollector
{
  /**
   * @param TTNFormData $data
   */
  protected function collectSenderData($data)
  {
    $this->data['Sender'] = $data->getSender();
    $this->data['ContactSender'] = $data->getContactSender();
    $this->data['SendersPhone'] = $data->getSenderPhone();
    $this->data['SenderCityName'] = $data->getSenderSettlementName();
    $this->data['SenderArea'] = $data->getSenderSettlementArea();
    $this->data['SenderAreaRegions'] = $data->getSenderSettlementRegion();
    $this->data['SenderAddressName'] = $data->getSenderStreet();
    $this->data['SenderHouse'] = $data->getSenderHouse();
    $this->data['SenderFlat'] = $data->getSenderFlat();
  }
}