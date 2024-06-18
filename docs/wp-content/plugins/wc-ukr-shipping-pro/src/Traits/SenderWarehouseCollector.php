<?php

namespace kirillbdev\WCUkrShipping\Traits;

use kirillbdev\WCUkrShipping\Model\TTNFormData;

if ( ! defined('ABSPATH')) {
  exit;
}

trait SenderWarehouseCollector
{
  /**
   * @param TTNFormData $data
   */
  protected function collectSenderData($data)
  {
    $this->data['Sender'] = $data->getSender();
    $this->data['ContactSender'] = $data->getContactSender();
    $this->data['CitySender'] = $data->getSenderCity();
    $this->data['SenderAddress'] = $data->getSenderAddress();
    $this->data['SendersPhone'] = $data->getSenderPhone();
  }
}