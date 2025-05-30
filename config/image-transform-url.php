<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Public Path
    |--------------------------------------------------------------------------
    |
    | Here you may configure the public path/prefix where the images are stored.
    | If you are storing the images in 'storage/app/public', the typically
    | linked public path would be 'storage'.
    |
    */

    'public_path' => env('IMAGE_TRANSFORM_PUBLIC_PATH', 'images'),

    /*
    |--------------------------------------------------------------------------
    | Route Prefix
    |--------------------------------------------------------------------------
    |
    | Here you may configure the route prefix of the image transformer.
    |
    */

    'route_prefix' => env('IMAGE_TRANSFORM_ROUTE_PREFIX', 'image-transform'),

    /*
    |--------------------------------------------------------------------------
    | Enabled Options
    |--------------------------------------------------------------------------
    |
    | Here you may configure the options which are enabled for the image
    | transformer.
    |
    */

    'enabled_options' => env('IMAGE_TRANSFORM_ENABLED_OPTIONS', [
        'width',
        'height',
        'format',
        'quality',
        'flip',
        'contrast',
        'version',
        'background',
        // 'blur'
    ]),

    /*
    |--------------------------------------------------------------------------
    | Image Cache
    |--------------------------------------------------------------------------
    |
    | Here you may configure the image cache settings. The cache is used to
    | store the transformed images for a certain amount of time. This is
    | useful to prevent reprocessing the same image multiple times.
    | The cache is stored in the configured cache disk.
    |
    */

    'cache' => [
        'enabled' => env('IMAGE_TRANSFORM_CACHE_ENABLED', true),
        'lifetime' => env('IMAGE_TRANSFORM_CACHE_LIFETIME', 60 * 24 * 7), // 7 days
        'disk' => env('IMAGE_TRANSFORM_CACHE_DISK', 'local'),
    ],

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
    ],
];
