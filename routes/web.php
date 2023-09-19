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
use App\Framework\Libraries\View;

$route->get('/2', 'WelcomeController@index2');
$route->get('/1', [WelcomeController::class, 'index']);
$route->get('/', function() {
    return View::render('welcome', [
        'text' => 'Fahli',
    ]);
});