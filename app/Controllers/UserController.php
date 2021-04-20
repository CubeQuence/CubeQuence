<?php

declare(strict_types=1);

namespace App\Controllers;

use CQ\Controllers\Controller;
use CQ\Response\HtmlResponse;
use CQ\Response\Respond;

class UserController extends Controller
{
    /**
     * Dashboard screen.
     */
    public function dashboard(): HtmlResponse
    {
        return Respond::twig(
            view: 'dashboard.twig'
        );
    }
}
