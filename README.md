# Laravel PHProfiler

[![Latest Stable Version](http://poser.pugx.org/phprofiler/laravel-phprofiler/v)](https://packagist.org/packages/phprofiler/laravel-phprofiler) 
[![Total Downloads](http://poser.pugx.org/phprofiler/laravel-phprofiler/downloads)](https://packagist.org/packages/phprofiler/laravel-phprofiler)
[![Latest Unstable Version](http://poser.pugx.org/phprofiler/laravel-phprofiler/v/unstable)](https://packagist.org/packages/phprofiler/laravel-phprofiler)
[![License](http://poser.pugx.org/phprofiler/laravel-phprofiler/license)](https://packagist.org/packages/phprofiler/laravel-phprofiler)
[![PHP Version Require](http://poser.pugx.org/phprofiler/laravel-phprofiler/require/php)](https://packagist.org/packages/phprofiler/laravel-phprofiler)

Laravel middleware to capture PHProfiler profiling data. This package is compatible with Laravel 9, 10, and 11.

## Installation

You can install the package via composer:

```bash
composer require phprofiler/laravel-phprofiler
```

If you are using a version of Laravel that does not automatically discover packages, you will need to manually add the service provider in config/app.php:
```php
'providers' => [
    // Other Service Providers
    PHProfiler\PHProfilerServiceProvider::class,
],
```

## Publishing the Configuration
To publish the configuration file, run the following command:
```bash
php artisan vendor:publish --provider="PHProfiler\PHProfilerServiceProvider"
```

This will publish the configuration file to config/phprofiler.php.

## Configuration
Add the following to your .env file:
```dotenv
PHPROFILER_ENABLED=true
PHPROFILER_DSN={Get your DSN from the PHProfiler UI}
```

You can customize the configuration by editing the config/phprofiler.php file.

## Usage

Once the package is installed and configured, the middleware will automatically capture PHProfiler profiling data and send it to the configured endpoint.

The middleware is automatically registered and added to the web middleware group. If you need to add it to a specific route or group, you can do so in your app/Http/Kernel.php file:

```php
protected $middleware = [
    // ...
    \PHProfiler\PHProfilerMiddleware::class,
];
```

## License
The Apache 2.0 License (Apache-2.0). Please see [License File](LICENSE) for more information.

## Contributing
Contributions are welcome! Please feel free to submit a Pull Request.

## Issues
If you encounter any issues, please create a new issue in the GitHub Issue Tracker.