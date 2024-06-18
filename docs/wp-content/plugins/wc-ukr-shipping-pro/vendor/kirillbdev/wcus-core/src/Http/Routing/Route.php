<?php

namespace kirillbdev\WCUSCore\Http\Routing;

use kirillbdev\WCUSCore\Foundation\Container;
use kirillbdev\WCUSCore\Http\Contracts\ResponseInterface;
use kirillbdev\WCUSCore\Http\Middleware\VerifyCsrfToken;
use kirillbdev\WCUSCore\Http\Request;

if ( ! defined('ABSPATH')) {
    exit;
}

class Route
{
    private $action;
    private $controller;
    private $method;
    private $public = false;
    private $middleware = [
        VerifyCsrfToken::class
    ];

    public function __construct($action, $controller, $method, $options = [])
    {
        $this->action = $action;
        $this->controller = $controller;
        $this->method = $method;

        if (isset($options['public'])) {
            $this->public = true;
        }

        if ( ! empty($options['middleware'])) {
            $this->middleware = array_merge($this->middleware, $options['middleware']);
        }
    }

    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * @param array $data
     */
    public function dispatch($data)
    {
        $request = new Request($data);

        foreach ($this->middleware as $middleware) {
            $guard = new $middleware();

            if (method_exists($guard, 'handle')) {
                $guard->handle($request);
            }
        }

        $controller = Container::instance()->make($this->controller);

        // todo: throws exception if $response not implement ResponseInterface
        /* @var ResponseInterface $response */
        $response = call_user_func([ $controller, $this->method ], $request);
        $response->send();
    }
}