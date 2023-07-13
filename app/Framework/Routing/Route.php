<?php
/*
| Urban PHP Framework
| Copyright (c) 2023 Muhammad Fahli Saputra <saputra@fahli.net>
| https://github.com/fahlisaputra/urban
| 
*/

namespace App\Framework\Routing;

class Route {

    public $routes = [];

    private function addRoute($httpMethod, $route, $handler)
    {
        $this->routes[$httpMethod][$route] = $handler;
        return $this;
    }

    public function get($route, $handler)
    {
        return $this->addRoute(RouteMethod::GET, $route, $handler);
    }

    public function post($route, $handler)
    {
        return $this->addRoute(RouteMethod::POST, $route, $handler);
    }

    public function put($route, $handler)
    {
        return $this->addRoute(RouteMethod::PUT, $route, $handler);
    }

    public function patch($route, $handler)
    {
        return $this->addRoute(RouteMethod::PATCH, $route, $handler);
    }

    public function delete($route, $handler)
    {
        return $this->addRoute(RouteMethod::DELETE, $route, $handler);
    }

    public function getRoutes()
    {
        return $this->routes;
    }
}