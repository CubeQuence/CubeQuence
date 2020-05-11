<?php

namespace App\Middleware;

use App\Helpers\AuthHelper;
use lucacastelnuovo\Helpers\Str;
use lucacastelnuovo\Helpers\Session;
use MiladRahimi\PhpRouter\Middleware;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Diactoros\Response\JsonResponse;

class SessionMiddleware implements Middleware
{
    /**
     * Validate PHP session.
     *
     * @param Request $request
     * @param $next
     *
     * @return mixed
     */
    public function handle(ServerRequestInterface $request, $next)
    {
        if (!AuthHelper::valid()) {
            Session::destroy();

            if (!Str::contains($request->getHeader('content-type')[0], '/json')) {
                return new RedirectResponse('/auth/logout', 403);
            }

            return new JsonResponse([
                'success' => false,
                'errors' => [
                    'status' => 403,
                    'title' => 'invalid_session',
                    'detail' => 'Session expired or IP mismatch'
                ]
            ], 403);
        }

        Session::set('last_activity', time());

        return $next($request);
    }
}
