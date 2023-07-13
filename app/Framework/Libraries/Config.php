<?php
/*
| Urban PHP Framework
| Copyright (c) 2023 Muhammad Fahli Saputra <saputra@fahli.net>
| https://github.com/fahlisaputra/urban
| 
*/

function config($key) {
    include base() . '/config.php';

    $keys = explode('.', $key);

    foreach ($keys as $key) {
        $config = $config[$key];
    }

    return $config;
}