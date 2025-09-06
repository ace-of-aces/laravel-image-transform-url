# Rate Limiting

This package can limit the number of transformations the image transformation route processes **per path and IP address** within a given time frame.

The rate limit applies only to new transformation requests and does not affect previously cached images.

By default, rate limiting is disabled for the `local` and `testing` app environments so it doesn't distract you during development. You can configure the rate limit settings in the `image-transform-url.php` configuration file.

```php
/*
|--------------------------------------------------------------------------
| Rate Limit
|--------------------------------------------------------------------------
|
| Below you may configure the rate limit applied to each image transformation
| by path and IP address. It is recommended to set this to a low value,
| e.g. 2 requests per minute, to prevent abuse.
|
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
