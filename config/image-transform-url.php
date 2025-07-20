<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Source Directories
    |--------------------------------------------------------------------------
    |
    | Here you may configure the directories from which the image transformer
    | is allowed to serve images. For security reasons, it is recommended
    | to only allow directories which are already publicly accessible.
    |
    | Important: The public storage directory should be addressed directly via
    | storage('app/public') instead of the public_path('storage') link.
    |
    */

    'source_directories' => [
        'images' => public_path('images'),
        'storage' => storage_path('app/public/images'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Source Directory
    |--------------------------------------------------------------------------
    |
    | Below you may configure the default source directory which is used when
    | no specific path prefix is provided in the URL. This should be one of
    | the keys from the source_directories array.
    |
    */

    'default_source_directory' => env('IMAGE_TRANSFORM_DEFAULT_SOURCE_DIRECTORY', 'images'),

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
        'max_size_mb' => env('IMAGE_TRANSFORM_CACHE_MAX_SIZE_MB', 100), // 100 MB
        'clear_to_percent' => env('IMAGE_TRANSFORM_CACHE_CLEAR_TO_PERCENT', 80), // 80% of max size
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
    |
    */

    'rate_limit' => [
        'enabled' => env('IMAGE_TRANSFORM_RATE_LIMIT_ENABLED', true),
        'disabled_for_environments' => env('IMAGE_TRANSFORM_RATE_LIMIT_DISABLED_FOR_ENVIRONMENTS', [
            'local',
            'testing',
        ]),
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
