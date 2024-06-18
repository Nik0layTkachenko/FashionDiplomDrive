<?php

namespace kirillbdev\WCUSCore\Foundation;

use kirillbdev\WCUSCore\Http\Routing\Router;

if ( ! defined('ABSPATH')) {
    exit;
}

abstract class Kernel
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var array
     */
    protected $modules = [];

    protected function __construct()
    {
        $this->container = Container::instance($this->dependencies());
        $this->router = $this->container->make(Router::class);

        View::setBasePath($this->viewPath());

        do_action('wcus_container_init', $this->container);
    }

    public function init()
    {
        foreach ($this->modules() as $module) {
            $this->initModule($module);
        }

        do_action('wcus_kernel_init', $this);
    }

    /**
     * @param string $module
     */
    public function initModule($module)
    {
        $moduleInstance = $this->container->make($module);
        $moduleInstance->init();

        if (wp_doing_ajax() && method_exists($module, 'routes')) {
            $routes = $moduleInstance->routes();

            foreach ($routes as $route) {
                $this->router->addRoute($route);
            }
        }

        $this->modules[] = $moduleInstance;
    }

    /**
     * Returns list of kernel modules.
     * @return string[]
     */
    abstract public function modules();

    /**
     * Returns plugin entities dependencies.
     * @return array
     */
    abstract public function dependencies();

    /**
     * Returns base view path.
     * @return string
     */
    abstract public function viewPath() : string;
}