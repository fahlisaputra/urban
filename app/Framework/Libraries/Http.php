<?php
/*
| Urban PHP Framework
| Copyright (c) 2023 Muhammad Fahli Saputra <saputra@fahli.net>
| https://github.com/fahlisaputra/urban
| 
*/

function getRequestUri()
{
    $uri = $_SERVER['REQUEST_URI'];
    $uri = explode('?', $uri);
    $uri = $uri[0];
    $uri = '/' . trim($uri, '/');

    $root = __DIR__;
    $root = str_replace('\app\Framework\Libraries', '', $root);
    $root = str_replace('/app/Framework/Libraries', '', $root);
    
    // check if the uri contains the root folder name
    if (strpos($uri, basename($root)) !== false) {
        $uri = str_replace(basename($root), '', $uri);
    }

    // check if uri contains two or more slashes on the first character
    if (substr($uri, 0, 2) == '//') {
        $uri = substr($uri, 1);
    }

    return $uri;
}