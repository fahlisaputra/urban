<?php
/*
| Urban PHP Framework
| Copyright (c) 2023 Muhammad Fahli Saputra <saputra@fahli.net>
| https://github.com/fahlisaputra/urban
| 
*/

namespace App\Framework;

class App {
    public function init($routes) {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        $uri = getRequestUri();
        if (array_key_exists($uri, $routes[$method])) {
            // check if the route is callable closure

            if (is_array($routes[$method][$uri])) {
                $route = $routes[$method][$uri];
                $controller = new $route[0];
                $controller->{$route[1]}();
            } elseif (is_callable($routes[$method][$uri])) {
                $routes[$method][$uri]();
            } else {
                // if the route is a controller
                $route = explode('@', $routes[$method][$uri]);
                $controllerName = 'App\\Controllers\\' . $route[0];
                $controller = new $controllerName();
                $controller->{$route[1]}();
            }

        } else {
            echo "404";
        }
    }
}