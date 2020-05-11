<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;

class Controller
{
    // private $request;
    private $twig;

    /**
     * Provide access for child classes
     * 
     * @return void
     */
    public function __construct()
    {
        // Start twig engine
        $loader = new FilesystemLoader('../views');
        $this->twig = new Environment($loader /* , ['cache' => '../storage/views'] */);
        $this->twig->addGlobal('analytics', config('analytics'));
    }

    /**
     * Shorthand redirect function
     *
     * @param string $to
     * @param integer $code optional
     * 
     * @return RedirectResponse
     */
    protected function redirect($to, $code = 302)
    {
        return new RedirectResponse($to, $code);
    }

    /**
     * Shorthand HTML response function
     *
     * @param string $view
     * @param array $parameters
     * @param integer $code optional
     * 
     * @return HtmlResponse
     */
    protected function respond($view, $parameters = [], $code = 200)
    {
        return new HtmlResponse(
            $this->twig->render(
                $view,
                $parameters
            ),
            $code
        );
    }

    /**
     * Shorthand JSON response function
     * 
     * @param array $data
     * @param integer $code optional
     * 
     * @return JsonResponse
     */
    protected function respondJson($data = [], $code = 200)
    {
        return new JsonResponse([
            'success' => true,
            'data' => $data
        ], $code);
    }

    /**
     * Shorthand JSON error response function
     *
     * @param string $title
     * @param string $detail optional
     * @param integer $code optional
     * 
     * @return JsonResponse
     */
    protected function respondJsonError($title, $detail = null, $code = 400)
    {
        return new JsonResponse([
            'success' => false,
            'errors' => [
                'status' => $code,
                'title' => $title,
                'detail' => $detail

            ]
        ], $code);
    }
}
