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

    private function addRoute($httpMethod, $route, $handler)
    {
        global $_routes;

        $params = trim($route, '/');
        $params = explode('/', $params);

        $instance = $this->setInstance($httpMethod, $route, $handler);

        foreach ($params as $param) {
            $path = new RoutePath();
            $path->name = $param;
            $path->static = true;
            $path->optional = false;
            $path->index = array_search($param, $params);

            if (preg_match('/\{(.*)\}/', $param, $matches)) {

                // check if parameter is exist
                if (in_array($matches[1], array_column($instance->params, 'name'))) {
                    throw new FrameworkException("Parameter {$matches[1]} already exist");
                }

                $data = new RouteParam();
                $data->name = $matches[1];
                $data->optional = false;
                $data->position = array_search($param, $params);

                $path->static = false;
                // Check if the parameter is optional
                if (preg_match('/\{(.*)\?\}/', $param, $matches)) {
                    $data->optional = true;
                    $path->optional = true;
                }
                $instance->params[] = $data;
            }

            $instance->details[] = $path;
        }
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

    public static function determineCurrentRouteByURI($uri) {

    }
}