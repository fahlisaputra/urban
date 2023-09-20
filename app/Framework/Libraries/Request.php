<?php

namespace App\Framework\Libraries;

use App\Framework\Application;

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
        $uri = getRequestUri();
        $method = $_SERVER['REQUEST_METHOD'];
        $routes = $this->app->getRoutes();
        $route = null;
        foreach ($routes as $r) {
            if ($r->route == $uri && $r->method == $method) {
                $route = $r;
                break;
            }
        }
        if ($route) {
            $handler = $route->handler;
            $handler = explode('@', $handler);
            $controller = $handler[0];
            $method = $handler[1];
            $controller = "App\\Controllers\\{$controller}";
            $controller = new $controller();
            $controller->$method();
        } else {
            echo '404';
        }
    }
}
