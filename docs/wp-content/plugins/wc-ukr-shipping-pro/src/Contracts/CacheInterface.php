<?php

namespace kirillbdev\WCUkrShipping\Contracts;

if ( ! defined('ABSPATH')) {
  exit;
}

interface CacheInterface
{
  public function get($hash);
  public function set($hash, $value);
  public function clear();
}