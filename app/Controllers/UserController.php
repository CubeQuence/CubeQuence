<?php

namespace App\Controllers;

class UserController extends Controller
{
    /**
     * Dashboard screen
     * 
     * @return Html
     */
    public function dashboard()
    {
        return $this->respond('dashboard.twig');
    }
}
