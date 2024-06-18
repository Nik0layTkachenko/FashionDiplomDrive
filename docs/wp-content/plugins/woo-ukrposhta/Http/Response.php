<?php

namespace deliveryplugin\Ukrposhta\Http;

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
}
