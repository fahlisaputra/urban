<?php
/*
| Urban PHP Framework
| Copyright (c) 2023 Muhammad Fahli Saputra <saputra@fahli.net>
| https://github.com/fahlisaputra/urban
| 
*/

namespace App\Framework\Routing;

use App\Framework\Exceptions\FrameworkException;

class Route {
    private $method;
    private $route;
    private $handler;
    private $params = [];
    private $name;
    private $middlewares = [];
    
    private function setInstance($httpMethod, $route, $handler) {
        $instance = new RouteInstance();
        $instance->method = $httpMethod;
        $instance->route = $route;
        $instance->handler = $handler;

        $this->method = $httpMethod;
        $this->route = $route;
        $this->handler = $handler;

        return $instance;
    }

    public static function split($uri) {
        $uri = trim($uri, '/');
        $paths = explode('/', $uri);
        $result = array();
        foreach($paths as $path) {
            if (!(trim($path) == '' || trim($path) == '\\')) {
                $result[] = $path;
            }
        }
        return $result;
    }

    private static function splitPath($uri, callable $callback) {
        $paths = static::split($uri);
        foreach ($paths as $path) {
            $callback($path, $paths);
        }
    }
    private static function countSplitPath($uri) {
        $paths = static::split($uri);
        return count($paths);
    }

    private function addRoute($httpMethod, $route, $handler)
    {
        $instance = $this->setInstance($httpMethod, $route, $handler);
        global $_routes;

        static::splitPath($route, function($path, $paths) use ($instance) {
            $routePath = new RoutePath();
            $routePath->index = array_search($path, $paths);
            $routePath->name = $path;
            $routePath->static = true;
            $routePath->optional = false;

            if (preg_match('/\{(.*)\}/', $path, $matches)) {
                // check if parameter is exist
                if (in_array($matches[1], array_column($instance->params, 'name'))) {
                    throw new FrameworkException("Parameter {$matches[1]} already exist");
                }

                $data = new RouteParam();
                $data->name = $matches[1];
                $data->optional = false;
                $data->position = array_search($path, $paths);

                $routePath->static = false;
                // Check if the parameter is optional
                if (preg_match('/\{(.*)\?\}/', $path, $matches)) {
                    $data->optional = true;
                    $routePath->optional = true;
                }
                $instance->params[] = $data;
            }

            $instance->details[] = $routePath;
        });

        $_routes[] = $instance;
        return $this;
    }

    public function name($name)
    {
        // check if name already exist
        global $_routes;
        foreach ($_routes as $route) {
            if ($route->name == $name) {
                throw new FrameworkException("Route name {$name} already exist");
            }
        }

        if (empty($this->route)) {
            throw new FrameworkException("Route does not exist");
        }
        $this->name = $name;

        // change name on global routes
        foreach ($_routes as $key => $route) {
            if ($route->route == $this->route) {
                $_routes[$key]->name = $name;
            }
        }
        
        return $this;
    }

    public static function get($route, $handler)
    {
        $instance = new Route();
        return $instance->addRoute(RouteMethod::GET, $route, $handler);
    }

    public function post($route, $handler)
    {
        return static::addRoute(RouteMethod::POST, $route, $handler);
    }

    public function put($route, $handler)
    {
        return static::addRoute(RouteMethod::PUT, $route, $handler);
    }

    public function patch($route, $handler)
    {
        return static::addRoute(RouteMethod::PATCH, $route, $handler);
    }

    public function delete($route, $handler)
    {
        return static::addRoute(RouteMethod::DELETE, $route, $handler);
    }

    public function middleware($middleware)
    {
        $this->middlewares[] = $middleware;
        return $this;
    }

    public function getMiddlewares()
    {
        return $this->middlewares;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getHandler()
    {
        return $this->handler;
    }

    public function getName()
    {
        return $this->name;
    }

    public static function getRoutes()
    {
        global $_routes;
        return $_routes;
    }

    public static function getRouteByName($name)
    {
        global $_routes;
        foreach ($_routes as $route) {
            if ($route->name == $name) {
                return $route;
            }
        }
        return null;
    }

    public static function predictRoute() {
        $uri = getRequestUri();
        global $_routes;

        foreach ($_routes as $route) {
            $route_data = json_encode($route);
            $route_data = json_decode($route_data, true);
            if (static::checkRoute($uri, $route_data)) {
                return $route;
            }
        }

        return null;
    }

    private static function checkRoute($uri, $route) {
        $count = static::countSplitPath($uri);
        $_uri = static::split($uri);
        $index = -1;
        $valid = true;

        if (count($route['details']) < $count) {
            return false;
        }

        foreach($route['details'] as $path) {
            $index++;
            if (!$path['static']) {
                if (!$path['optional']) {
                    if (!isset($_uri[$index])) {
                        $valid = false;
                    }
                }
            } else {
                if (isset($_uri[$index])) {
                    if ($path['name'] != $_uri[$index]) {
                        $valid = false;
                    }
                } else {
                    $valid = false;
                }
            }
        }

        return $valid;
    }
}