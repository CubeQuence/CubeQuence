<?php

declare(strict_types=1);

namespace App\Controllers;

use CQ\Controllers\Controller;
use CQ\Helpers\AuthHelper;
use CQ\Helpers\ConfigHelper;
use CQ\Helpers\SessionHelper;
use CQ\OAuth\Client;
use CQ\OAuth\Exceptions\OAuthException;
use CQ\OAuth\Flows\Provider\DeviceCode;
use CQ\Response\HtmlResponse;
use CQ\Response\JsonResponse;
use CQ\Response\Respond;

class AuthDeviceController extends Controller
{
    private Client $client;

    /**
     * Auth provider config
     */
    public function __construct()
    {
        $this->client = new Client(
            flowProvider: new DeviceCode(),
            authorizationServer: ConfigHelper::get(key: 'auth.authorization_server'),
            clientId: ConfigHelper::get(key: 'auth.client_id'),
            clientSecret: ConfigHelper::get(key: 'auth.client_server')
        );
    }

    /**
     * Redirect to login portal.
     */
    public function request(): HtmlResponse
    {
        $startData = $this->client->start();

        SessionHelper::set(
            name: 'oauth_device_code',
            data: $startData->device_code
        );

        return Respond::twig(
            view: 'partials/device.twig',
            parameters: [
                'qr' => $startData->uri,
            ]
        );
    }

    /**
     * Callback for OAuth.
     */
    public function callback(): JsonResponse
    {
        try {
            $tokens = $this->client->callback(
                queryParams: $this->request->getQueryParams(),
                storedVar: SessionHelper::get('oauth_device_code')
            );
        } catch (OAuthException $th) {
            if (!$th->getMessage()) {
                return Respond::prettyJson(message: '');
            }

            return Respond::prettyJson(
                message: $th->getMessage(),
                code: 400
            );
        } catch (\Throwable) {
            return Respond::prettyJson(
                message: 'Unknown error occured!',
                code: 400
            );
        }

        $user = $this->client->getUser(
            accessToken: $tokens->getAccessToken()
        );

        if (!$user->isAllowed()) {
            return Respond::prettyJson(
                message: 'Please register or contact the administrator!',
                code: 403
            );
        }

        return Respond::prettyJson(
            message: 'You are logged in!',
            data: [
                'redirect' => AuthHelper::login(user: $user),
            ]
        );
    }
}
