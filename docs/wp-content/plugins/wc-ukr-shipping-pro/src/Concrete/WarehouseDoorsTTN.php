<?php

namespace kirillbdev\WCUkrShipping\Concrete;

use kirillbdev\WCUkrShipping\Base\TTNBase;
use kirillbdev\WCUkrShipping\Traits\RecipientDoorsCollector;
use kirillbdev\WCUkrShipping\Traits\SenderWarehouseCollector;

if ( ! defined('ABSPATH')) {
  exit;
}

class WarehouseDoorsTTN extends TTNBase
{
  use SenderWarehouseCollector, RecipientDoorsCollector;
}