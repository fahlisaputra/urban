<?php

namespace App\Controllers;

use App\Framework\Libraries\View;

class WelcomeController {
    
        public function index()
        {
            View::render('welcome', [
                'text' => 'Hello World'
            ]);
        }
}