<?php

namespace CubeQuence\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Captcha
{
    /**
     * Validate reCaptchaV2
     *
     * @param string $secret
     * @param string $response
     * 
     * @return bool
     */
    public static function recaptcha($secret, $response)
    {
        return self::validate(
            'https://www.google.com/recaptcha/api/siteverify',
            $secret,
            $response
        );
    }

    /**
     * Validate hCaptcha
     *
     * @param string $secret
     * @param string $response
     * 
     * @return bool
     */
    public static function hcaptcha($secret, $response)
    {
        return self::validate(
            'https://hcaptcha.com/siteverify',
            $secret,
            $response
        );
    }

    /**
     * Validate captcha
     *
     * @param string $url
     * @param string $secret
     * @param string $response
     * 
     * @return bool
     */
    private static function validate($url, $secret, $response)
    {
        $guzzle = new Client();

        try {
            $guzzle->request('POST', $url, [
                'form_params' => [
                    'secret' => $secret,
                    'response' => $response,
                    'remoteip' => $_SERVER['REMOTE_ADDR']
                ],
            ]);
        } catch (RequestException $e) {
            return false;
        }

        return true;
    }
}
