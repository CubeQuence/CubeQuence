# CubeQuence Helpers

#### JWT

```PHP
<?php

use Exception;
use CubeQuence\Helpers\JWT;

$keypair = JWT::generateKeys(2048);

$jwtProvider = new JWT([
    'iss' => 'https://domain.com', // The domain on which the JWT is created
    'aud' => '', // Optional: Intented domain on which the token will be used
    'private_key' => $keypair['privatekey'], // Private RSA key
    'public_key' => $keypair['publickey'] // Public RSA key
]);

$seconds_valid = 3600 // 1hour
$aud = null; // Optional: If not provided the aud set in the constructor will be used
$token = $jwtProvider::create([
    'sub' => 'foo@bar.com'
], $seconds_valid, $aud);

try {
    $aud = null; // Optional: If not provided, null will be used
    $claims = JWT::valid($token, $intended_aud);
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}

var_dump($claims);
exit;
```

#### AppsClient

```php
<?php

use Exception;
use CubeQuence\Helpers\AppsClient;

$authProvider = new AppsClient([
    'app_id' => 'xyz123', // The gumroad ID for the app
    'app_url' => 'https://domain.com' // The domain on which the app is hosted
]);

$authUrl = $this->provider->getAuthorizationUrl();
header("Location: {$authUrl}");

if (isset($_GET['code'])) {
    try {
        $data = $authProvider->getData($_GET['code'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
    } catch (Exception $e) {
        var_dump($e->getMessage());
        exit;
    }

    var_dump($data);
    exit;
}
```

#### Session

```php
<?php

use CubeQuence\Helpers\Session;

// Set session var
echo Session::set('foo', 'Hello World!'); // returns input

// Get session var
echo Session::get('foo');

// Remove session var
Session::unset('foo');

// Destroy all session vars
Session::destroy();
```

#### Str

```php
<?php

use CubeQuence\Helpers\Str;

Str::contains('very long string', 'long'); // returns bool

Str::beginsWith('very long string', 'very'); // returns bool

echo Str::escape('<script>alert("xss detected")</script>'); // returns safe string

echo Str::random(32); // return random string, param defines length
```

#### Arr

```php
<?php

use CubeQuence\Helpers\Arr;

$array = [
    'foo' => 'bar',
    'abc' => [
        'first' => 123,
        'second' => 456
    ]
]

Arr::accessible($array, 'abc'); // returns bool

Arr::exists($array, 'abc'); // returns bool

echo Arr::get($array, 'abc.first', 'fallback_value');
```

#### Captcha

```php
<?php

use CubeQuence\Helpers\Captcha;

$secret = '123'; // site secret

Captcha::recaptcha($secret, $_REQUEST['g-recaptcha-response']); // returns bool for success
Captcha::hcaptcha($secret, $_REQUEST['h-captcha-response']); // returns bool for success
```
