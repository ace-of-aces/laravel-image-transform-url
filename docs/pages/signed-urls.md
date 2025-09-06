# Signed URLs

This package provides the option to generate signed URLs for images from specific source directories powered by [Laravel's URL signing feature](https://laravel.com/docs/urls#signed-urls).

This can be useful for securing access to images that should not be publicly accessible without proper authorization or should only be available in a scaled-down version.

::: info
Signed URLs also ensure that the provided options cannot be modified client-side.
:::

::: warning
The signed URL feature does not restrict access to public images.
If you want to secure access to images, ensure that the source directories you want signed URLs for are not publicly accessible.
:::

## Setup

To enable signed URLs, set the `signed_urls.enabled` option to `true` in your `image-transform-url.php` configuration.

You then need to specify the source directories to which signed URLs should apply in the `signed_urls.for_source_directories` array.

For example:

```php
'source_directories' => [
    'images' => public_path('images'),
    'protected' => storage_path('app/private/protected-images'),
],

// ...

'signed_urls' => [
    'enabled' => env('IMAGE_TRANSFORM_SIGNED_URLS_ENABLED', false),
    'for_source_directories' => env('IMAGE_TRANSFORM_SIGNED_URLS_FOR_SOURCE_DIRECTORIES', [
        'protected',
    ]),
],
```

## Generating Signed URLs

To generate a signed URL for an image, you can use the `ImageTransformUrl` facade:

```php
use AceOfAces\LaravelImageTransformUrl\Facades\ImageTransformUrl;

$options = [
    'blur' => 50,
    'width' => 500,
];

$blurredImage = ImageTransformUrl::signedUrl(
    'example.jpg',
    $options,
    'protected'
);
```

## Temporary Signed URLs

If you would like to generate a signed URL that expires after a certain time, you can use the `temporarySignedUrl` method:

```php
use AceOfAces\LaravelImageTransformUrl\Facades\ImageTransformUrl;

$options = [
    'blur' => 50,
    'width' => 500,
];

$temporarySignedUrl = ImageTransformUrl::temporarySignedUrl(
    'example.jpg',
    $options,
    now()->addMinutes(60),
    'protected'
);
```

::: info
You can also use the generic `signedUrl` method to generate temporary signed URLs. This method accepts an `$expiration` parameter, which defaults to `null`. If you provide a value, it generates a temporary signed URL.
:::
