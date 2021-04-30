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
            'error' => 'Please try again',
            'logout' => 'You have been logged out',
            'not_verified' => 'Please verify your email',
            'not_registered' => 'Please create an account',
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

    public function upload()
    {
        return Respond::prettyJson(
            message: 'Upload Successfull'
        );
    }
}
