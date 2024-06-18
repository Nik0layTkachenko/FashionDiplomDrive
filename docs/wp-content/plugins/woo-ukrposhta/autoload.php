<?php

\spl_autoload_register(function ($class) {
  if (stripos($class, 'deliveryplugin\Ukrposhta') !== 0) {
    return;
  }

  $classFile = str_replace('\\', '/', substr($class, strlen('deliveryplugin\Ukrposhta') + 1) . '.php');
  include_once __DIR__ . '/' . $classFile;
});
