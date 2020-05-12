<?php

namespace App\Controllers;

class GeneralController extends Controller
{
    /**
     * Index screen
     */
    public function index()
    {
        return $this->respond('index.twig');
    }
}
