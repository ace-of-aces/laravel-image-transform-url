# Installation

## Requirements

-   PHP \>= 8.4
-   Laravel 12.x
-   [GD PHP Library](https://www.php.net/manual/en/book.image.php)

::: tip
If you want to use the file caching feature (highly recommended), a configured `Storage` disk and a `Cache` driver is required. More info in the [Image Caching](#image-caching) section.
:::

### Important `php.ini` settings❗
1. The underlying image processing library (GD) can use alot more RAM than regular web requests. It's highly recommended to set your memory limit to *at least* 256MB.
```
memory_limit=512M
```
2. If you have the [Swoole extension](https://laravel.com/docs/octane#swoole) installed, make sure you have the following setting to [avoid conflicts](https://github.com/ace-of-aces/laravel-image-transform-url/issues/4) with Laravel's `defer` helper which this package uses.
```
swoole.use_shortname=off
```

## Installation

Install the package via composer:

```bash
composer require ace-of-aces/laravel-image-transform-url
```

Publish the config file with:

```bash
php artisan vendor:publish --tag="image-transform-url-config"
```
