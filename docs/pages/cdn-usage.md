# Usage with CDNs

The package is designed to work seamlessly with CDNs like Cloudflare, BunnyCDN, and others.

The most important configuration is the [`Cache-Control`](https://developer.mozilla.org/de/docs/Web/HTTP/Reference/Headers/Cache-Control) header, which you can customize to your liking in the `image-transform-url.php` configuration file.

```php
/*
    |--------------------------------------------------------------------------
    | Response Headers
    |--------------------------------------------------------------------------
    |
    | Below you may configure the response headers which are added to the
    | response. This is especially useful for controlling caching behavior
    | of CDNs.
    |
    */

    'headers' => [
        'Cache-Control' => env('IMAGE_TRANSFORM_HEADER_CACHE_CONTROL', 'immutable, public, max-age=2592000, s-maxage=2592000'),
        // more headers can be added here
    ],
```
