<?php
/*
| Urban PHP Framework
| Copyright (c) 2023 Muhammad Fahli Saputra <saputra@fahli.net>
| https://github.com/fahlisaputra/urban
| 
*/

namespace App\Framework\Routing;

class RoutePath
{
    public int $index;
    public string $name;
    public bool $static;
    public bool $optional;

    public function __construct()
    {
        $this->index = 0;
        $this->name = '';
        $this->static = false;
        $this->optional = false;
    }

    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            if ($name == 'index') {
                $this->index = $value;
            } else if ($name == 'name') {
                $this->name = $value;
            } else if ($name == 'static') {
                $this->static = $value;
            } else if ($name == 'optional') {
                $this->optional = $value;
            }
        }
    }
}
