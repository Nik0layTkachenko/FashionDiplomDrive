<?php

namespace kirillbdev\WCUkrShipping\Model\Invoice\Parameters;

if ( ! defined('ABSPATH')) {
    exit;
}

class Seat
{
    /**
     * @var float
     */
    private $weight;

    /**
     * @var float
     */
    private $width;

    /**
     * @var float
     */
    private $height;

    /**
     * @var float
     */
    private $length;

    /**
     * @var bool
     */
    private $noBox;

    /**
     * Seat constructor.
     * @param float $weight
     * @param float $width
     * @param float $height
     * @param float $length
     * @param bool $noBox
     */
    public function __construct($weight, $width, $height, $length, $noBox = false)
    {
        $this->weight = (float)$weight;
        $this->width = (float)$width;
        $this->height = (float)$height;
        $this->length = (float)$length;
        $this->noBox = $noBox;
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