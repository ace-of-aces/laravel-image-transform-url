# Laravel Image Transform URL

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ace-of-aces/laravel-image-transform-url.svg?style=flat-square)](https://packagist.org/packages/ace-of-aces/laravel-image-transform-url)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/ace-of-aces/laravel-image-transform-url/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/ace-of-aces/laravel-image-transform-url/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/ace-of-aces/laravel-image-transform-url/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/ace-of-aces/laravel-image-transform-url/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/ace-of-aces/laravel-image-transform-url.svg?style=flat-square)](https://packagist.org/packages/ace-of-aces/laravel-image-transform-url)

Easy, URL-based image transformations inspired by [Cloudflare Images](https://developers.cloudflare.com/images/transform-images/transform-via-url/).

**Features:**

-   ✈️ Use URL parameters to transform images on the fly
-   🔧 Support for various transformations like resizing, compression, and format conversion
-   ⚡ Automatic caching of transformed images for faster loading times
-   🌍 Easy integration with CDNs for even faster global delivery

## Requirements

-   PHP \>= 8.4
-   Laravel 12.x

If you want to use the file caching feature (highly recommended), a configured `Storage` disk with a `local` driver is required.

> [!IMPORTANT]
> It is highly recommended to set a minimum memory limit of 256MB in your `php.ini` file to avoid memory issues when images are being processed.

## Installation

Install the package via composer:

```bash
composer require ace-of-aces/laravel-image-transform-url
```

Publish the config file with:

```bash
php artisan vendor:publish --tag="image-transform-url-config"
```

## Usage

1. Configure the package via `config/image-transform-url.php` to set your [`public_path`](https://laravel.com/docs/12.x/helpers#method-public-path) directory, from where you want to transform the images.
   It is recommended to use a dedicated directory for your images in order to have a separation of concerns.

2. Test your first image transformation:

Use the following URL format to transform your images:

```
http://<domain>/<route-prefix>/<options>/<path-to-your-image.<jpg|jpeg|png|gif|webp>>
```

for example:

```
http://localhost:8000/image-transform/width=250,quality=80,format=webp/foo/bar/example.jpg
```

## Options

> [!NOTE]
> The options are separated by commas and their values are appended with equal signs. The order of options does not matter.

| Option     | Description                          | Type    | Description / Possible Values                                                   |
| ---------- | ------------------------------------ | ------- | ------------------------------------------------------------------------------- |
| `width`    | Set the width of the image.          | integer | Values greater than the original width will be ignored.                         |
| `height`   | Set the height of the image.         | integer | Values greater than the original height will be ignored.                        |
| `quality`  | Set the quality of the image.        | integer | `0` to `100`                                                                    |
| `format`   | Set the format of the image.         | string  | Supported formats: `jpg`, `jpeg`, `png`, `gif`, `webp`.                         |
| `blur`     | Set the blur level of the image.     | integer | `0` to `100`                                                                    |
| `contrast` | Set the contrast level of the image. | integer | `-100` to `100`                                                                 |
| `flip`     | Flip the image.                      | string  | `h`(horizontal), `v`(vertical), `hv`(horizontal and vertical)                   |
| `version`  | Version number of the image.         | integer | Any positive integer. More info in the [Image Caching](#image-caching) section. |

> [!CAUTION]
> The `blur` option is a resource-intensive operation and may cause memory issues if the image is too large. It is recommended to use this option with caution, or disable it in the config.

## Image Caching

This package comes with the default option to automatically store and serve images statically for the requested options within the caching lifetime.

> [!NOTE]
> Having this feature enabled (default behavior) will help to reduce the load on your server and speed up image delivery.

The processed images are stored in the `storage/app/private/_cache/image-transform-url` directory by default. You can change the disk configuration in the `image-transform-url.php` configuration file.

> [!CAUTION]
> When using this option, there is one caveat to be aware of:

Source images are considered to be stale content by their file name and path.

If the content of an original source image changes, but the file name stays the same, the cached images will not be updated automatically until the cache expires.
To force a revalidation, you can either:

1.  change the image's file name
2.  move it into another subdirectory, which will change its path
3.  change the version number (integer) in the options (e.g. `version=2`)
4.  or flush the entire cache of your application using the `php artisan cache:clear` command.

## Usage with CDNs

This package is designed to work seamlessly with CDNs like Cloudflare, BunnyCDN, and others.

The most important configuration is the [`Cache-Control`](https://developer.mozilla.org/de/docs/Web/HTTP/Reference/Headers/Cache-Control) header, which you can customize to your liking in the `image-transform-url.php` configuration file.

## Error Handling

The route handler of this package is designed to be robust against invalid options, paths and file names, while also not exposing additional information of your applications public directory structure.

This is why the route handler will return a `404` response if:

-   a requested image does not existn at the specified path
-   the requested image is not a valid image file
-   the provided options are not in the correct format (`key=value`, no trailing comma, etc.)

The only other HTTP error that can be returned is a `429` response, which indicates that the request was rate-limited.

If parts of the given route options are invalid, the route handler will ignore them and only apply the valid options.

Example:

```
http://localhost:8000/image-transform/width=250,quality=foo,format=webp/example.jpg
```

will be processed as:

```
http://localhost:8000/image-transform/width=250,format=webp/example.jpg
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

TODO

## Credits

-   [Aaron Francis](https://github.com/aarondfrancis) for the [original idea and foundational work](https://aaronfrancis.com/2025/a-cookieless-cache-friendly-image-proxy-in-laravel-inspired-by-cloudflare-9e95f7e0)
-   [Cloudflare Images](https://developers.cloudflare.com/images/transform-images/transform-via-url/) for the URL-Syntax structure
-   [Intervention Image](https://image.intervention.io/v3) for the underlying image processing

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
