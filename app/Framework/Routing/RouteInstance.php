<?php
/*
| Urban PHP Framework
| Copyright (c) 2023 Muhammad Fahli Saputra <saputra@fahli.net>
| https://github.com/fahlisaputra/urban
| 
*/

namespace App\Framework\Routing;

class RouteInstance
{
    public string $method;
    public string $route;
    public $handler;
    public array $params = [];
    public array $middlewares = [];
    public $name;
}
