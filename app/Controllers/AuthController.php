<?php

namespace App\Controllers;

use CQ\Controllers\Auth;
use CQ\Crypto\Symmetric;
use CQ\Crypto\Password;
use CQ\Config\Config;
use CQ\DB\DB;

class AuthController extends Auth
{
    /**
     * Delete user webhook listener
     *
     * @param object $request
     *
     * @return Json
     */
    public function delete($request)
    {
        $plaintext_key = Symmetric::getKey(null, 'encryption');
        $encrypted_hash = $request->getHeader('authorization')[0];
        $context = Config::get('auth.secret');

        if (!Password::verify($plaintext_key, $encrypted_hash, $context)) {
            return $this->respondJson('Invalid authorization header', [], 403);
        }

        try {
            $type = $request->data->event->type;
            $user_id = $request->data->event->user->id;
        } catch (\Throwable $th) {
            return $this->respondJson('Provided data was malformed', [], 400);
        }

        if (!in_array($type, [
            'user.delete',
            'user.registration.delete',
        ])) {
            return $this->respondJson('Invalid webhook type', [], 400);
        }

        // Insert app specific deletion queries below
        DB::delete('example', ['user_id' => $user_id]);

        return $this->respondJson('Webhook Received');
    }
}
