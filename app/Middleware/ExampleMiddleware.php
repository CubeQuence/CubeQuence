<?php

namespace App\Middleware;

use CQ\Middleware\Middleware;

class ExampleMiddleware extends Middleware
{
    /**
     * Custom actions.
     *
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handleChild($next)
    {
        /*
            [
                'getBody' => $this->request->getBody(),
                'getContents' => $this->request->getBody()->getContents(),
                'getSize' => $this->request->getBody()->getSize(),
                'getHeader' => $this->request->getHeader('host'),
                'getHeaderLine' => $this->request->getHeaderLine('host'),
                // 'getHeaders' => $this->request->getHeaders(),
                'getMethod' => $this->request->getMethod(),
                'getParsedBody' => $this->request->getParsedBody(),
                'getQueryParams' => $this->request->getQueryParams(),
                'getRequestTarget' => $this->request->getRequestTarget(),
                'getUploadedFiles' => $this->request->getUploadedFiles(),
                'getPath' => $this->request->getUri()->getPath(),
            ]
        */

        return $next($this->request);
    }
}
