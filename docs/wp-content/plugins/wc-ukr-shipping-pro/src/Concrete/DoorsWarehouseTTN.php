<?php

namespace kirillbdev\WCUkrShipping\Concrete;

use kirillbdev\WCUkrShipping\Base\TTNBase;
use kirillbdev\WCUkrShipping\Traits\RecipientWarehouseCollector;
use kirillbdev\WCUkrShipping\Traits\SenderDoorsCollector;

if ( ! defined('ABSPATH')) {
  exit;
}

class DoorsWarehouseTTN extends TTNBase
{
  use SenderDoorsCollector, RecipientWarehouseCollector;
}