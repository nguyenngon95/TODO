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
        $this->get('add', 'WorkController', 'add');
        $this->post('add', 'WorkController', 'create');
        $this->get('edit/{id}', 'WorkController', 'edit');
        $this->post('edit/{id}', 'WorkController', 'update');
        $this->get('delete/{id}', 'WorkController', 'delete');

        $this->get('calendar', 'WorkController', 'calendar');
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
        // get id from path
        preg_match('/\d+/', $path, $matches);

        if (count($matches) > 0) {
            $id = $matches[0];

            if ($method === 'GET') {
                $_GET['id'] = $id;
            } else {
                $_POST['id'] = $id;
            }
        }

        // check edit/1 is matched with edit/{id}
        $path = preg_replace('/\d+/', '{id}', $path);
        
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