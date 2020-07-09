<?php

namespace App\Controllers;

class HomeController {

    /**
     * home page
     */
    public function index()
    {
        return view('pages/home');
    }
}
