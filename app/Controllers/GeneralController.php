<?php

declare(strict_types=1);

namespace App\Controllers;

use CQ\Controllers\Controller;
use CQ\Helpers\AuthHelper;
use CQ\Response\HtmlResponse;
use CQ\Response\Respond;

class GeneralController extends Controller
{
    /**
     * Index screen.
     */
    public function index(): HtmlResponse
    {
        $msg = match ($this->requestHelper->getQueryParam('msg')) {
            'error' => 'Please try again!',
            'logout' => 'You have been logged out!',
            'not_registered' => 'Please register or contact the administrator!',
            default => ''
        };

        return Respond::twig(
            view: 'index.twig',
            parameters: [
                'message' => $msg,
                'logged_in' => AuthHelper::isValid(),
            ]
        );
    }

    /**
     * Error screen.
     */
    public function error(string $code): HtmlResponse
    {
        $error = match ($code) {
            '403' => 'Oops! Access denied',
            '404' => 'Oops! Page not found',
            '500' => 'Oops! Server error',
            default => 'Oops! Unknown Error'
        };

        $description = match ($code) {
            '403' => 'Access to this page is forbidden',
            '404' => 'The page you requested could not be found',
            '500' => 'We are experiencing some technical issues',
            default => 'Unknown error occured'
        };

        return Respond::twig(
            view: 'error.twig',
            parameters: [
                'code' => $code,
                'error' => $error,
                'description' => $description,
            ],
            code: (int) $code
        );
    }
}
