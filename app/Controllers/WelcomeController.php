<?php

namespace App\Controllers;

use App\Framework\Libraries\View;

class WelcomeController {
    
        public function index()
        {
            $tes = "Hello World";
            View::render('welcome', [
                'text' => $tes
            ]);
        }

        public function index2()
        {
            View::render('welcome', [
                'text' => 'Urban Framework from Index2'
            ]);
        }
}