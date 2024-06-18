<?php

namespace kirillbdev\WCUkrShipping\Contracts;

if ( ! defined('ABSPATH')) {
  exit;
}

interface NotificatorInterface
{
  public function notifyUserByOrderId($orderId);
}