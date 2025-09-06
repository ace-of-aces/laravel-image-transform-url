# Installation

## Requirements

-   PHP \>= 8.4
-   Laravel 12.x
-   [GD](https://www.php.net/manual/en/book.image.php) or [Imagick](https://www.php.net/manual/en/book.imagick.php) PHP extension installed and [enabled](#driver-configuration)

::: tip
If you want to use the file caching feature (highly recommended), a configured `Storage` disk and a `Cache` driver are required. More info in the [Image Caching](/image-caching) section.
:::

## Installation

Install the package via composer:

```bash
composer require ace-of-aces/laravel-image-transform-url
```

Publish the config file with:

```bash
php artisan vendor:publish --tag="image-transform-url-config"
```

## Driver Configuration

To use Imagick instead of the default GD library for image processing (recommended for performance), you must [change the default image driver](https://image.intervention.io/v3/getting-started/frameworks#application-wide-configuration) for the underlying [Intervention Image](https://image.intervention.io/) package.

::: info
The [`libvips` driver](https://github.com/Intervention/image-driver-vips) is currently not supported.
:::

## PHP Settings

Depending on your environment, you may need to adjust some `php.ini` settings.

1. If you are using the default GD driver, be aware that it can use alot more RAM than regular web requests. It's highly recommended to set your memory limit to *at least* 256 MB.
```
memory_limit=512M
```
2. If you have the [Swoole extension](https://laravel.com/docs/octane#swoole) installed, ensure you have the following setting to [avoid conflicts](https://github.com/ace-of-aces/laravel-image-transform-url/issues/4) with Laravel's `defer` helper, which this package uses.
```
swoole.use_shortname=off
```
