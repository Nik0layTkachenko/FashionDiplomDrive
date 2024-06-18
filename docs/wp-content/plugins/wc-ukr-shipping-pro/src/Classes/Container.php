<?php

namespace kirillbdev\WCUkrShipping\Classes;

if ( ! defined('ABSPATH')) {
  exit;
}

class Container
{
  /**
   * List of container services.
   *
   * @var array
   */
  private $services = [];

  /**
   * List of container singleton instances.
   *
   * @var array
   */
  private $instances = [];

  /**
   * PSR 11 implementation
   *
   * @param string $id
   */
  public function has($id)
  {
    return isset($this->services[$id]);
  }

  /**
   * PSR 11 implementation
   *
   * @param string $id
   */
  public function get($id)
  {
    if ($this->has($id)) {
      return new $this->services[$id];
    }

    throw new \InvalidArgumentException('Invalid service id.');
  }

  /**
   * Bind concrete implementation.
   *
   * @param string $abstract
   * @param string $concrete
   */
  public function bind($abstract, $concrete)
  {
    if ( ! $this->has($abstract)) {
      $this->services[$abstract] = $concrete;
    }
  }

  /**
   * Bind or get singleton implementation.
   *
   * @param string $abstract
   * @param string null $concrete
   *
   * @return mixed|null
   */
  public function singleton($abstract, $concrete = null)
  {
    if ( ! $concrete) {
      if ( ! isset($this->instances[$abstract])) {
        $this->instances[$abstract] = $this->get($abstract);
      }

      return $this->instances[$abstract];
    }

    $this->bind($abstract, $concrete);

    return null;
  }
}