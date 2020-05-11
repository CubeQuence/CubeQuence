<?php

namespace App\Middleware;

use MiladRahimi\PhpRouter\Middleware;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\EmptyResponse;

class CORSMiddleware implements Middleware
{
    /**
     * Add CORS headers to requests
     *
     * @param Request $request
     * @param $next
     *
     * @return mixed
     */
    public function handle(ServerRequestInterface $request, $next)
    {
        $headers = [
            'Access-Control-Allow-Origin'  => implode(", ", config('cors.allow_origins')),
            'Access-Control-Allow-Headers' => implode(", ", config('cors.allow_headers')),
            'Access-Control-Allow-Methods' => implode(", ", config('cors.allow_methods')),
        ];

        $response = $next($request);

        foreach ($headers as $key => $value) {
            $response = $response->withHeader($key, $value);
        }

        if ($request->getMethod() !== 'POST') {
            return new EmptyResponse(204, $headers);
        }

        return $response;
    }
}
