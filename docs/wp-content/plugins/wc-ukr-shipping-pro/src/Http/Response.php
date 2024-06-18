<?php

namespace kirillbdev\WCUkrShipping\Http;

if ( ! defined('ABSPATH')) {
    exit;
}

class Response
{
  public static function make($type, $data = [])
  {
    $result = [
      'success' => $type === 'success' ? true : false,
      'data'    => $data
    ];

    return $result;
  }

  public static function makeAjax($type, $data = [])
  {
    $result = [
      'success' => $type === 'success' ? true : false,
      'data'    => $data
    ];

    header('Content-Type: application/json');

    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    wp_die();
  }

  public static function makeException($message)
  {
    $result = [
      'success' => false,
      'exception' => $message
    ];

    header('Content-Type: application/json');

    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    wp_die();
  }
}