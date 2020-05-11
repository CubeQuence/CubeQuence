<?php

namespace CubeQuence\Helpers;

use Exception;
use CubeQuence\Helpers\JWT;

class AppsClient
{
    private $provider_url;
    private $app_id;
    private $app_url;

    /**
     * Define client variables
     * 
     * @param array $data
     * 
     * @return void
     */
    public function __construct($data)
    {
        $this->provider_url = 'https://apps.lucacastelnuovo.nl';
        $this->app_id = $data['app_id'];
        $this->app_url = $data['app_url'];
    }

    /**
     * Generate authorization url
     * 
     * @return string
     */
    public function getAuthorizationUrl()
    {
        $url = "{$this->provider_url}/launch/{$this->app_id}";

        return $url;
    }

    /**
     * Validate code and return data
     *
     * @param string $code
     * @param string $user_ip optional
     * @param string $user_agent optional
     * 
     * @return array
     * @throws Exception
     */
    public function getData($code, $user_ip = null, $user_agent = null)
    {
        if (!$code) {
            throw new Exception('Token not provided');
        }

        $config = $this->getConfig();

        $provider = new JWT([
            'iss' => $this->provider_url,
            'aud' => $this->app_url,
            'public_key' => $config->public_key
        ]);

        $claims = $provider->valid($code);

        if ($claims->type !== 'auth') {
            throw new Exception('Token type not valid');
        }

        if ($user_ip && $claims->user_ip !== $user_ip) {
            throw new Exception('Authorized IP is different from current IP');
        }

        if ($user_agent && $claims->user_agent !== $user_agent) {
            throw new Exception('Authorized UserAgent is different from current UserAgent');
        }

        return $claims;
    }

    /**
     * Get jwt config from provider
     *
     * @return object
     */
    public function getConfig()
    {
        $data = file_get_contents("{$this->provider_url}/jwt");
        $config = json_decode($data)->data;

        return $config;
    }
}
