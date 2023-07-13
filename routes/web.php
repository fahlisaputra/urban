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

use App\Controllers\DataController;

$route->get('/halo', [DataController::class, 'index']);

?>