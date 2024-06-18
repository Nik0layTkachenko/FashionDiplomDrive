<?php

namespace kirillbdev\WCUkrShipping\Helpers;

if ( ! defined('ABSPATH')) {
  exit;
}

class OptionsHelper
{
  public static function maybeNeedAdditionalFields()
  {
    return 1 === (int)wc_ukr_shipping_get_option('wcus_inject_additional_fields');
  }
}