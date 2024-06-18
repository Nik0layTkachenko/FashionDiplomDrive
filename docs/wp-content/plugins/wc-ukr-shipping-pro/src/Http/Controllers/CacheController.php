<?php

namespace kirillbdev\WCUkrShipping\Http\Controllers;

use kirillbdev\WCUkrShipping\Contracts\CacheInterface;
use kirillbdev\WCUSCore\Http\Controller;
use kirillbdev\WCUSCore\Http\Request;

if ( ! defined('ABSPATH')) {
    exit;
}

class CacheController extends Controller
{
    /**
     * @var CacheInterface
     */
    private $cacheInterface;

    /**
     * CacheController constructor.
     * @param CacheInterface $cacheInterface
     */
    public function __construct($cacheInterface)
    {
        $this->cacheInterface = $cacheInterface;
    }

    /**
     * @param Request $request
     * @return \kirillbdev\WCUSCore\Http\Contracts\ResponseInterface
     */
    public function clearCache($request)
    {
        $this->cacheInterface->clear();

        return $this->jsonResponse([
            'success' => true
        ]);
    }
}