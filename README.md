# Application installation command

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-style]][link-style]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]


This package adds `artisan app:install` command, which runs defined commands related to the current environment

## Installation

_*For Laravel <= 5.4*_ - Via Composer

``` bash
$ composer require mad-web/laravel-initializer:~0.1.0
```

_*For Laravel >= 5.5*_ - Via Composer

``` bash
$ composer require mad-web/laravel-initializer
```

_*For Laravel < 5.5*_ - Now add the service provider in config/app.php file:
```php
'providers' => [
    // ...
    MadWeb\Initializer\InitializerServiceProvider::class,
];
```
Run `artisan make:installer` command to create installer config in `app` directory

You can override config key where stored current environment, just publish config file, and set `env_config_key` value
```bash
php artisan vendor:publish --provider="MadWeb\Initializer\InitializerServiceProvider" --tag=config
```
By default it set to `app.env`

## Usage

InstallerConfig contents:
```php
namespace App;

use MadWeb\Initializer\Contracts\Runner;

class InstallerConfig
{
    public function production(Runner $run)
    {
        return $run
            ->artisan('key:generate')
            ->artisan('migrate')
            ->external('npm', 'install', '--production')
            ->external('npm', 'run', 'production')
            ->artisan('route:cache')
            ->artisan('config:cache')
            ->artisan('optimize')
            ->external('composer', 'dump-autoload', '--optimize');
    }

    public function local(Runner $run)
    {
        return $run
            ->artisan('key:generate')
            ->artisan('migrate')
            ->external('npm', 'install')
            ->external('npm', 'run', 'development');
    }
}
```

You can add any another method which called the same as your environment name, for example `staging` and define different commands

If you need to run commands with root privileges separately you can define method with next convention
```php
namespace App;

use MadWeb\Initializer\Contracts\Runner;

class InstallerConfig
{
    public function local(Runner $run)
    {
        return $run
            ->artisan('key:generate')
            ->artisan('migrate')
            ->external('npm', 'install')
            ->external('npm', 'run', 'development');
    }
    
    public function localRoot(Runner $run)
    {
        return $run
            ->external('service', 'php-fpm', 'restart')
            ->external('supervisorctl', 'reread')
            ->external('supervisorctl', 'update');
    }
}
```
Run it by passing "root" option - `artisan app:install --root`

If you want to move config file from the `app` directory to a different place, just add a new binding in the `AppServiceProvider`
```php
$this->app->bind('project.installer', \AnotherNameSpace\InstallerConfig::class);
```

#### List of commands available to run
```php
$run
    ->artisan('command', ['argument' => 'argument_value', '-param' => 'param_value', '--option' => 'option_value', ...]) // Artisan command
    ->external('command', 'argument', 'argument_value', '-param', 'param_value', '--option=option_value', ...) // Any external command
    ->callable('command', 'argument', ...) // Callable function (like for call_user_func)
    ->dispatch(new JobClass) // Dispatch job task
    ->dispatchNow(new JobClass) // Dispatch job task without queue
    ->publish([ServiceProvider::class]) // Publish package assets
    ->publish([ServiceProvider::class => 'tag']) // Publish package assets with tag
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email madweb.dev@gmail.com instead of using the issue tracker.

## Credits

- [Mad Web](https://github.com/mad-web)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/mad-web/laravel-initializer.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/mad-web/laravel-initializer/master.svg?style=flat-square
[ico-style]: https://styleci.io/repos/100302581/shield
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/mad-web/laravel-initializer.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/mad-web/laravel-initializer.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/mad-web/laravel-initializer.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/mad-web/laravel-initializer
[link-travis]: https://travis-ci.org/mad-web/laravel-initializer
[link-style]: https://styleci.io/repos/100302581
[link-scrutinizer]: https://scrutinizer-ci.com/g/mad-web/laravel-initializer/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/mad-web/laravel-initializer
[link-downloads]: https://packagist.org/packages/mad-web/laravel-initializer
[link-author]: https://github.com/mad-web
[link-contributors]: ../../contributors
