<?php

namespace App\Controllers;

use App\Framework\Libraries\View;

class WelcomeController {
    
        public function index()
        {
            View::render('welcome', [
                'text' => 'Urban Framework from Index'
            ]);
        }

        public function index2()
        {
            View::render('welcome', [
                'text' => 'Urban Framework from Index2'
            ]);
        }
}