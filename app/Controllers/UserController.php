<?php

namespace App\Controllers;

use CQ\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Dashboard screen.
     *
     * @return Html
     */
    public function dashboard()
    {
        return $this->respond('dashboard.twig');
    }
}
