<p align="center"><a href="https://github.com/CubeQuence/CubeQuence" target="_blank" rel="noopener"><img src="https://rawcdn.githack.com/CubeQuence/CubeQuence/855a8fe836989ca40c4e50a889362975eab9ac43/public/assets/images/banner.png"></a></p>

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
2. Edit `.env`
3. `composer migrate`
4. `composer seed`
5. Start development server `php -S localhost:8080 -t public`

For deployment

1. `git clone https://github.com/CubeQuence/CubeQuence`
2. `composer install --optimize-autoloader --no-dev`
3. Edit `.env`
4. `composer migrate`

## Security Vulnerabilities

Please review [our security policy](https://github.com/CubeQuence/CubeQuence/security/policy) on how to report security vulnerabilities.

## License

The CubeQuence framework is open-sourced software licensed under the [MIT license](LICENSE.md).
