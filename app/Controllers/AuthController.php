<?php

declare(strict_types=1);

namespace App\Controllers;

use CQ\Controllers\Controller;
use CQ\Crypto\Models\SymmetricKey;
use CQ\Crypto\Password;
use CQ\DB\DB;
use CQ\Helpers\AuthHelper;
use CQ\Helpers\ConfigHelper;
use CQ\Helpers\SessionHelper;
use CQ\OAuth\Client;
use CQ\OAuth\Flows\Provider\AuthorizationCode;
use CQ\OAuth\Models\UserModel;
use CQ\Response\JsonResponse;
use CQ\Response\RedirectResponse;
use CQ\Response\Respond;

class AuthController extends Controller
{
    private Client $client;

    /**
     * Auth provider config
     */
    public function __construct()
    {
        $this->client = new Client(
            flowProvider: new AuthorizationCode(
                redirectUri: ConfigHelper::get(key: 'app.url') . '/auth/callback'
            ),
            authorizationServer: ConfigHelper::get(key: 'auth.authorization_server'),
            clientId: ConfigHelper::get(key: 'auth.client_id'),
            clientSecret: ConfigHelper::get(key: 'auth.client_secret')
        );
    }

    /**
     * Redirect to login portal.
     */
    public function request(): RedirectResponse
    {
        $startData = $this->client->start();

        SessionHelper::set(
            name: 'oauth_state',
            data: $startData->state
        );

        return Respond::redirect(
            url: $startData->uri
        );
    }

    /**
     * Callback for OAuth.
     */
    public function callback(): RedirectResponse|JsonResponse
    {
        // TODO: fake login
        return Respond::json('test');

        echo $this->requestHelper->getQueryParam('debug');
        exit;

        // if ($this->requestHelper->getQueryParam('debug')) {
        //     $user = new UserModel(
        //         allowed: true,
        //         id: '1234',
        //         email: 'foo@bar.gmail.com',
        //         emailVerified: true,
        //         roles: [
        //             'user'
        //         ]
        //     );

        //     return Respond::redirect(
        //         url: AuthHelper::login(user: $user)
        //     );
        // }

        // try {
        //     $tokens = $this->client->callback(
        //         queryParams: $this->request->getQueryParams(),
        //         storedVar: SessionHelper::get('oauth_state')
        //     );

        //     $user = $this->client->getUser(
        //         accessToken: $tokens->getAccessToken()
        //     );
        // } catch (\Throwable) {
        //     return Respond::redirect(
        //         url: '/?msg=error'
        //     );
        // }

        // if (!$user->isAllowed()) {
        //     return Respond::redirect(
        //         url: '/?msg=not_registered'
        //     );
        // }


        // return Respond::redirect(
        //     url: AuthHelper::login(user: $user)
        // );
    }

    /**
     * Logout through oauth server
     */
    public function logout(): RedirectResponse
    {
        return Respond::redirect(
            url: $this->client->logout()
        );
    }

    /**
     * Delete user webhook listener
     */
    // TODO: test this functionality
    public function delete(): JsonResponse
    {
        $plaintextKey = ConfigHelper::get('app.key');

        $key = new SymmetricKey(
            encodedKey: $plaintextKey
        );

        $password = new Password(
            key: $key
        );

        var_dump($this->request);

        $encryptedHash = $this->requestHelper->getHeader('authorization');
        $context = ConfigHelper::get('auth.secret');

        $verify = $password->verify(
            plaintextPassword: $plaintextKey,
            encryptedHashedPassword: $encryptedHash,
            context: $context
        );

        if (!$verify) {
            return Respond::prettyJson(
                message: 'Invalid authorization header',
                code: 403
            );
        }

        try {
            $type = $this->request->data->event->type;
            $userId = $this->request->data->event->user->id;
        } catch (\Throwable) {
            return Respond::prettyJson(
                message: 'Provided data was malformed',
                code: 400
            );
        }

        if (!in_array(
            needle: $type,
            haystack: [
                'user.delete',
                'user.registration.delete',
            ]
        )) {
            return Respond::prettyJson(
                message: 'Invalid webhook type',
                code: 400
            );
        }

        // TODO: Insert app specific deletion queries below
        DB::delete(
            table: 'example',
            where: [
                'user_id' => $userId
            ]
        );

        return Respond::prettyJson(
            message: 'Webhook Received'
        );
    }
}
