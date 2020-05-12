<?php

namespace App\Controllers;

use CQ\Response\Twig;
use CQ\Response\Html;
use CQ\Response\Json;
use CQ\Response\Redirect;

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
        $twig = new Twig(false); // TODO: based on Environment enable cache or not
        $this->twig = $twig->get();
        $this->twig->addGlobal('app', config('app'));
        $this->twig->addGlobal('analytics', config('analytics'));
    }

    /**
     * Shorthand redirect function
     *
     * @param string $to
     * @param integer $code optional
     * 
     * @return Redirect
     */
    protected function redirect($to, $code = 302)
    {
        return new Redirect($to, $code);
    }

    /**
     * Shorthand HTML response function
     *
     * @param string $view
     * @param array $parameters
     * @param integer $code optional
     * 
     * @return Html
     */
    protected function respond($view, $parameters = [], $code = 200)
    {
        return new Html(
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
     * @return Json
     */
    protected function respondJson($data = [], $code = 200)
    {
        return new Json([
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
     * @return Json
     */
    protected function respondJsonError($title, $detail = null, $code = 400)
    {
        return new Json([
            'success' => false,
            'errors' => [
                'status' => $code,
                'title' => $title,
                'detail' => $detail

            ]
        ], $code);
    }
}
