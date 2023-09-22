<?php

namespace App\Framework\Libraries;

use App\Framework\Application;
use App\Framework\Routing\Route;

class Request
{
    private $app;
    public static function get($param, $default = null)
    {
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                return $param ? (isset($_GET[$param]) ? $_GET[$param] : '') : $_GET;
                break;
            case 'POST':
                return $param ? (isset($_POST[$param]) ? $_POST[$param] : '') : $_POST;
                break;
            case 'PUT':
                parse_str(file_get_contents('php://input'), $_PUT);
                return $param ? (isset($_PUT[$param]) ? $_PUT[$param] : '') : $_PUT;
                break;
            case 'PATCH':
                parse_str(file_get_contents('php://input'), $_PATCH);
                return $param ? (isset($_PATCH[$param]) ? $_PATCH[$param] : '') : $_PATCH;
                break;
            case 'DELETE':
                parse_str(file_get_contents('php://input'), $_DELETE);
                return $param ? (isset($_DELETE[$param]) ? $_DELETE[$param] : '') : $_DELETE;
                break;
            default:
                return [];
                break;
        }
    }

    public static function all()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                return $_GET;
                break;
            case 'POST':
                return $_POST;
                break;
            case 'PUT':
                parse_str(file_get_contents('php://input'), $_PUT);
                return $_PUT;
                break;
            case 'PATCH':
                parse_str(file_get_contents('php://input'), $_PATCH);
                return $_PATCH;
                break;
            case 'DELETE':
                parse_str(file_get_contents('php://input'), $_DELETE);
                return $_DELETE;
                break;
            default:
                return [];
                break;
        }
    }

    public static function has($param)
    {
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                return isset($_GET[$param]);
                break;
            case 'POST':
                return isset($_POST[$param]);
                break;
            case 'PUT':
                parse_str(file_get_contents('php://input'), $_PUT);
                return isset($_PUT[$param]);
                break;
            case 'PATCH':
                parse_str(file_get_contents('php://input'), $_PATCH);
                return isset($_PATCH[$param]);
                break;
            case 'DELETE':
                parse_str(file_get_contents('php://input'), $_DELETE);
                return isset($_DELETE[$param]);
                break;
            default:
                return false;
                break;
        }
    }

    public function __construct(Application $app) {
        $this->app = $app;
    }
    
    public function handle() {
        $route = $this->app->route;
        $handler = $route->handler;

        $params = $this->params();
        if (is_array($handler)) {
            $controller = new $handler[0];
            $controller->{$handler[1]}(...$params);
        } elseif (is_callable($handler)) {
            call_user_func_array($handler, $params);
        } else {
            // if the route is a controller
            $handler = explode('@', $handler);
            $controllerName = 'App\\Controllers\\' . $handler[0];
            $controller = new $controllerName(...$params);
            $controller->{$handler[1]}();
        }
    }

    public function params($key = '') {
        $uri = getRequestUri();
        $_uri = Route::split($uri);
        $route = $this->app->route;
        $params = $route->params;

        if ($key) {
            foreach ($params as $param) {
                if ($param->name == $key) {
                    $position = $param->position;
                    if (isset($_uri[$position])) {
                        return $_uri[$position];
                    } else {
                        return null;
                    }
                }
            }
        }

        $extract = [];
        foreach ($params as $param) {
            $position = $param->position;
            if (isset($uri[$position])) {
                $extract[] = $_uri[$position];
            }
        }
        return $extract;
    }
}
