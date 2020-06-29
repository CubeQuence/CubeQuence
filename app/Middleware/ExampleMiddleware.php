<?php

namespace App\Middleware;

use CQ\Middleware\Middleware;

class ExampleMiddleware extends Middleware
{
    /**
     * Custom actions.
     *
     * @param $request
     * @param $next
     *
     * @return mixed
     */
    public function handle($request, $next)
    {
        /*
        [
            'method' => $request->getMethod(),
            'uri' => $request->getUri(),
            'body' => $request->getBody(),
            'parsedBody' => $request->getParsedBody(),
            'headers' => $request->getHeaders(),
            'queryStrings' => $request->getQueryParams(),
            'attributes' => $request->getAttributes(),
        ]
        */

        return $next($request);
    }
}
