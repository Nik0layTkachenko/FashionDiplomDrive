<?php

namespace kirillbdev\WCUkrShipping\Concrete;

use kirillbdev\WCUkrShipping\Base\TTNBase;
use kirillbdev\WCUkrShipping\Traits\RecipientWarehouseCollector;
use kirillbdev\WCUkrShipping\Traits\SenderWarehouseCollector;

if ( ! defined('ABSPATH')) {
  exit;
}

class WarehouseWarehouseTTN extends TTNBase
{
  use SenderWarehouseCollector, RecipientWarehouseCollector;
}