<?php
/*
| Urban PHP Framework
| Copyright (c) 2023 Muhammad Fahli Saputra <saputra@fahli.net>
| https://github.com/fahlisaputra/urban
| 
*/

namespace App\Framework;

use App\Framework\Bootstrap\HandleExceptions;
use App\Framework\Exceptions\FrameworkException;
use App\Framework\Console\Commands\ServeCommand;
use App\Framework\Libraries\Request;
use App\Framework\Routing\Route;
use Symfony\Component\Console\Application as ConsoleApplication;

class Application {
    
    private ConsoleApplication $console;
    private Request $request;

    public function __construct() {
        $this->console = new ConsoleApplication();
        $this->console->add(new ServeCommand());
    }

    public function runConsole() {
        try {
            $this->console->run();
        } catch (\Throwable $th) {
            throw new FrameworkException($th->getMessage(), $th->getCode(), $th);
        }
    }
    
    public function init() {
        echo json_encode(Route::predictRoute());
    }
}