<?php

namespace App\Middleware;

use MiladRahimi\PhpRouter\Middleware;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class RateLimitMiddleware implements Middleware
{
    /**
     * Ratelimit API
     *
     * @param Request $request
     * @param $next
     *
     * @return mixed
     */
    public function handle(ServerRequestInterface $request, $next)
    {
        // TODO: 1 request / 1 second / 1 ip

        $ratelimit_exceeded = false;
        if ($ratelimit_exceeded) {
            return new JsonResponse([
                'success' => false,
                'errors' => [
                    'status' => 429,
                    'title' => 'ratelimit_exceeded',
                    'detail' => 'Too many requests, please slow down!'
                ]
            ], 429);
        }

        return $next($request);
    }
}
