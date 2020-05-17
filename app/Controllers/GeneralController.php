<?php

namespace App\Controllers;

use CQ\Helpers\Auth;
use CQ\Controllers\Controller;

class GeneralController extends Controller
{
    /**
     * Index screen
     * 
     * @param object $request
     * 
     * @return Html
     */
    public function index($request)
    {
        $msg = $request->getQueryParams()['msg'] ?: '';
        $code = $request->getQueryParams()['code'] ?: '';

        if ($code) {
            return $this->redirect("/auth/callback?code={$code}");
        }

        if ($msg) {
            switch ($msg) {
                case 'logout':
                    $msg = 'You have been logged out!';
                    break;

                case 'token':
                    $msg = 'Invalid authentication!';
                    break;

                default:
                    $msg = '';
                    break;
            }
        }

        return $this->respond('index.twig', [
            'message' => $msg,
            'logged_in' => Auth::valid()
        ]);
    }

    /**
     * Error screen
     * 
     * @param string $httpcode
     * 
     * @return Html
     */
    public function error($code)
    {
        switch ($code) {
            case '403':
                $short_message = 'Oops! Access denied';
                $message = 'Access to this page is forbidden';
                break;
            case '404':
                $short_message = 'Oops! Page not found';
                $message = 'We are sorry, but the page you requested was not found';
                break;
            case '500':
                $short_message = 'Oops! Server error';
                $message = 'We are experiencing some technical issues';
                break;

            default:
                $short_message = 'Oops! Unknown Error';
                $message = 'Unknown error occured';
                $code = 400;
                break;
        }

        return $this->respond('error.twig', [
            'code' => $code,
            'short_message' => $short_message,
            'message' => $message
        ], $code);
    }
}
