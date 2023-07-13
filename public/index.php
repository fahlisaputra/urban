<?php
/*
| Urban PHP Framework
| Copyright (c) 2023 Muhammad Fahli Saputra <saputra@fahli.net>
| https://github.com/fahlisaputra/urban
| 
*/

define('URBAN_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__ . '/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Load Bootstrap File
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/../app/bootstrap.php';

use App\Framework\App;

$app = new App();
$app->init($route->getRoutes());
?>