<?php

namespace kirillbdev\WCUkrShipping\Services;

if ( ! defined('ABSPATH')) {
  exit;
}

class StorageService
{
  public static function getValue($key, $default = null, $force = false)
  {
    if (false === $force && self::maybeServiceDisabled()) {
      return null;
    }

    if (wc()->customer->get_id()) {
      return get_user_meta(wc()->customer->get_id(), $key, true) ?: $default;
    }

    return wc()->session->get($key, $default);
  }

  public static function setValue($key, $value)
  {
    if (wc()->customer->get_id()) {
      update_user_meta(wc()->customer->get_id(), $key, $value);
    }
    else {
      wc()->session->set($key, $value);
    }
  }

  public static function deleteValue($key)
  {
    if (wc()->customer->get_id()) {
      delete_user_meta(wc()->customer->get_id(), $key);
    }
    else {
      wc()->session->set($key, null);
    }
  }

  private static function maybeServiceDisabled()
  {
    return 0 === (int)wc_ukr_shipping_get_option('wc_ukr_shipping_np_save_warehouse');
  }
}