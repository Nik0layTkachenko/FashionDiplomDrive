<?php

namespace kirillbdev\WCUkrShipping\Model\Invoice\Address;

if ( ! defined('ABSPATH')) {
    exit;
}

class Settlement
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $area;

    /**
     * @var string
     */
    private $region;

    public function __construct($name, $area, $region)
    {
        $this->name = $name;
        $this->area = $area;
        $this->region = $region;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->$name;
    }
}