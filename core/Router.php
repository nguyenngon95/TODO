<?php

class Router
{
    protected $routes = [
        'GET' => [],
        'POST' => [],
    ];

    public function load()
    {
        $this->get('', 'WorkController', 'index');
    }

    public function get($path, $controller, $method)
    {
        $this->routes['GET'][$path] = compact('controller', 'method');
    }

    public function post($path, $controller, $method)
    {
        $this->routes['POST'][$path] = compact('controller', 'method');
    }

    public function direct(string $path, string $method)
    {
        if (array_key_exists($path, $this->routes[$method])) {
            return $this->callMethod(
                $this->routes[$method][$path]['controller'],
                $this->routes[$method][$path]['method']
            );
        }

        return view('error', ['error' => '404 Not Found!']);
    }    

    protected function callMethod($controller, $method)
    {
        $controller =  "Controllers\\{$controller}";
        $controllerInstance = new $controller;

        if (! method_exists($controller, $method)) {
            throw new Exception("{$controller} does not have '{$method}' method.");
        }

        return $controllerInstance->$method();
    }
}