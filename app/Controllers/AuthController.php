<?php

declare(strict_types=1);

namespace App\Controllers;

use CQ\Config\Config;
use CQ\Controllers\Auth;
use CQ\Crypto\Password;
use CQ\Crypto\Symmetric;
use CQ\DB\DB;
use CQ\Response\JsonResponse;

class AuthController extends Auth
{
    /**
     * Delete user webhook listener
     */
    public function delete(object $request): JsonResponse
    {
        $plaintext_key = Symmetric::getKey(null, 'encryption');
        $encrypted_hash = $request->getHeader('authorization');
        $context = Config::get('auth.secret');

        if (! Password::verify($plaintext_key, $encrypted_hash, $context)) {
            return $this->respond->prettyJson('Invalid authorization header', [], 403);
        }

        try {
            $type = $request->data->event->type;
            $user_id = $request->data->event->user->id;
        } catch (\Throwable) {
            return $this->respond->prettyJson('Provided data was malformed', [], 400);
        }

        if (! in_array($type, [
            'user.delete',
            'user.registration.delete',
        ])) {
            return $this->respond->prettyJson('Invalid webhook type', [], 400);
        }

        // Insert app specific deletion queries below
        DB::delete('example', ['user_id' => $user_id]);

        return $this->respond->prettyJson('Webhook Received');
    }
}
