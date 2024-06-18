<?php

namespace kirillbdev\WCUkrShipping\Concrete;

use kirillbdev\WCUkrShipping\Base\TTNBase;
use kirillbdev\WCUkrShipping\Traits\RecipientDoorsCollector;
use kirillbdev\WCUkrShipping\Traits\SenderDoorsCollector;

if ( ! defined('ABSPATH')) {
  exit;
}

class DoorsDoorsTTN extends TTNBase
{
  use SenderDoorsCollector, RecipientDoorsCollector;
}