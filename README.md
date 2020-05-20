<p align="center"><a href="https://github.com/Luca-Castelnuovo/CubeQuence" target="_blank" rel="noopener"><img src="https://i.imgur.com/SxUDZl9.png" width="400"></a></p>

<p align="center">
<a href="https://packagist.org/packages/cubequence/cubequence"><img src="https://poser.pugx.org/cubequence/cubequence/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/cubequence/cubequence"><img src="https://poser.pugx.org/cubequence/cubequence/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/cubequence/cubequence"><img src="https://poser.pugx.org/cubequence/cubequence/license.svg" alt="License"></a>
</p>

# CubeQuence

Ultra-Light custom php framework.

## Installation

For development

1. `composer create-project --prefer-dist cubequence/cubequence hello-world`
2. `yarn`
3. Edit `.env`
4. `composer migrate`
5. `composer seed`
6. Start development server `php -S localhost:8080 -t public`
7. In another terminal `yarn run development`

For production

1. `git clone https://github.com/laravel/laravel.git`
2. `composer install --optimize-autoloader --no-dev`
3. `yarn`
4. Edit `.env`
5. `composer migrate`
6. `yarn run production`

## Security Vulnerabilities

Please review [our security policy](https://github.com/Luca-Castelnuovo/CubeQuence/security/policy) on how to report security vulnerabilities.

## License

The CubeQuence framework is open-sourced software licensed under the [MIT license](LICENSE.md).
