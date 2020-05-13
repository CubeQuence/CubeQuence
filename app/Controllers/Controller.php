<?php

namespace App\Controllers;

use CQ\Helpers\App;
use CQ\Config\Config;
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
        $twig = new Twig(Config::get('cache.views') && !App::debug());
        $this->twig = $twig->get();
        $this->twig->addGlobal('app', Config::get('app'));
        $this->twig->addGlobal('analytics', Config::get('analytics'));
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
