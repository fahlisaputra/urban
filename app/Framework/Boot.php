<?php
/*
| Urban PHP Framework
| Copyright (c) 2023 Muhammad Fahli Saputra <saputra@fahli.net>
| https://github.com/fahlisaputra/urban
| 
*/

function base()
{
    return __DIR__ . '/../..';
}

require_once base() . '/config.php';
require_once base() . '/app/Framework/Libraries/Http.php';
require_once base() . '/app/Framework/Routing/RouteMethod.php';
require_once base() . '/app/Framework/Routing/Route.php';
require_once base() . '/app/Framework/Application.php';
require_once base() . '/app/Framework/Libraries/Config.php';

use App\Framework\Bootstrap\HandleExceptions;
use App\Framework\Libraries\DB;

// $handler = new HandleExceptions();
// $handler->bootstrap();

$_routes = array();

// load all files in routes folder
foreach (glob(base() . '/routes/*.php') as $file) {
    require_once $file;
}

$db = new DB();
function db()
{
    global $db;
    return $db;
}