<?php

/*
| ---------------------------------------------------------------
| Web Routes
| ---------------------------------------------------------------
| Urban PHP Framework
| Copyright (c) 2023 Muhammad Fahli Saputra <saputra@fahli.net>
| https://github.com/fahlisaputra/urban
| 
*/

use App\Controllers\WelcomeController;

$route->get('/', [WelcomeController::class, 'index']);

?>