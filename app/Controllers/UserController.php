<?php

declare(strict_types=1);

namespace App\Controllers;

use CQ\Controllers\Controller;
use CQ\Response\HtmlResponse;

class UserController extends Controller
{
    /**
     * Dashboard screen.
     */
    public function dashboard(): HtmlResponse
    {
        return $this->respond->twig('dashboard.twig');
    }

    public function debug($param = null): void
    {
        // var_dump($this->requestHelper);

        // return Respond::json([
        //     'getBody' => $this->request->getBody(),
        //     'getContents' => $this->request->getBody()->getContents(),
        //     'getSize' => $this->request->getBody()->getSize(),
        //     'getHeader' => $this->request->getHeader('host'),
        //     'getHeaderLine' => $this->request->getHeaderLine('host'),
        //     // 'getHeaders' => $this->request->getHeaders(),
        //     'getMethod' => $this->request->getMethod(),
        //     'getParsedBody' => $this->request->getParsedBody(),
        //     'getQueryParams' => $this->request->getQueryParams(),
        //     'getRequestTarget' => $this->request->getRequestTarget(),
        //     'getUploadedFiles' => $this->request->getUploadedFiles(),
        //     'getPath' => $this->request->getUri()->getPath(),
        // ]);

        // return Respond::json($this->request->data);

        echo 'Hello World!';
    }
}
