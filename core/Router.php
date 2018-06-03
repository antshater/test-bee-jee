<?php


namespace Core;

use Core\Request\Request;

class Router
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var Request
     */
    private $request;


    public function __construct(array $config, Request $request)
    {
        $this->config = $config;
        $this->request = $request;
    }

    private function controllerString()
    {
        $controller_string = $this->config[$this->request->routePath()] ?? null;
        return $controller_string ?: null;
    }

    public function controller(): ?Controller
    {
        if (!$this->controllerString()) {
            return null;
        }

        $controller_class = explode('@', $this->controllerString())[0];
        return new $controller_class($this->request);
    }

    public function controllerMethod(): string
    {
        if (!$this->controllerString()) {
            return null;
        }

        return explode('@', $this->controllerString())[1];
    }
}
