<?php

namespace App\Controllers;

use Exception;
use CQ\Helpers\App;
use CQ\Helpers\Str;
use CQ\Helpers\Session;
use CQ\Helpers\Request;
use CQ\Apps\Client;
use CQ\Config\Config;
use CQ\Controllers\Controller;

class AuthController extends Controller
{
    private $provider;

    /**
     * Initialize the provider
     * 
     * @return void
     */
    public function __construct()
    {
        $this->provider = new Client([
            'app_id' => Config::get('apps.id'),
            'app_url' => Config::get('app.url'),
            'debug' => App::debug()
        ]);
    }

    /**
     * Redirect to authorization portal
     * 
     * @return Redirect
     */
    public function request()
    {
        $authUrl = $this->provider->getAuthorizationUrl();

        return $this->redirect($authUrl);
    }

    /**
     * Callback for OAuth
     *
     * @param object $request
     * 
     * @return Redirect
     */
    public function callback($request)
    {
        $code = $request->getQueryParams()['code'];

        try {
            $data = $this->provider->getData($code, Request::ip(), Request::userAgent());
        } catch (Exception $e) {
            return $this->logout('token');
            // var_dump($e->getMessage());exit;
        }

        $id = Str::escape($data->sub);

        return $this->login($id, $data->variant, $data->exp);
    }

    /**
     * Create session
     * 
     * @param string $id
     * @param string $variant
     * @param string $expires
     *
     * @return Redirect
     */
    public function login($id, $variant, $expires)
    {
        $return_to = Session::get('return_to');

        Session::destroy();
        Session::set('id', $id);
        Session::set('variant', $variant);
        Session::set('ip', Request::ip());
        Session::set('expires', $expires);

        if ($return_to) {
            return $this->redirect($return_to);
        }

        return $this->redirect('/dashboard');
    }

    /**
     * Destroy session
     * 
     * @param string $msg optional
     *
     * @return Redirect
     */
    public function logout($msg = 'logout')
    {
        Session::destroy();

        if ($msg) {
            return $this->redirect("/?msg={$msg}");
        }

        return $this->redirect('/');
    }
}
