# Rate Limiting

Another feature of this package is the ability to limit the number of transformations that the image transformation route should process **per path and IP address** within a given time frame.

The rate limit will come into effect for new transformation requests only, and will not affect previously cached images.

By default, rate limiting is disabled for the `local` and `testing` app environements to not distract you when developing your app. You can configure the rate limit settings in the `image-transform-url.php` configuration file.

```php
/*
    |--------------------------------------------------------------------------
    | Rate Limit
    |--------------------------------------------------------------------------
    |
    | Below you may configure the rate limit which is applied for each image
    | new transformation by the path and IP address. It is recommended to
    | set this to a low value, e.g. 2 requests per minute, to prevent
    | abuse.
    */

    'rate_limit' => [
        'enabled' => env('IMAGE_TRANSFORM_RATE_LIMIT_ENABLED', true),
        'disabled_for_environments' => [
            'local',
            'testing',
        ],
        'max_attempts' => env('IMAGE_TRANSFORM_RATE_LIMIT_MAX_REQUESTS', 2),
        'decay_seconds' => env('IMAGE_TRANSFORM_RATE_LIMIT_DECAY_SECONDS', 60),
    ],
```
