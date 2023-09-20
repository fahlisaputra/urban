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
use App\Framework\Routing\Route;

Route::get('/2', 'WelcomeController@index2');
Route::get('/1', [WelcomeController::class, 'index']);
Route::get('/', function() {
    return View::render('welcome', [
        'text' => 'Fahli',
    ]);
});

Route::get('/info/{1?}/{2}', function ($a, $b) {
    echo $a . ' ' . $b;
})->name('info');