# Image Caching

This package can automatically store and serve images statically for the requested options within the caching lifetime.

> [!INFO]
> Enabling this feature (default) reduces server load and speeds up image delivery.

The processed images are stored in the `storage/app/private/_cache/image-transform-url` directory by default. You can change the disk configuration in the `image-transform-url.php` configuration file.

> [!IMPORTANT]
> However when using this option, there is one caveat to be aware of:
>
> **Source images are considered to be stale content by their file name and path.**

If the content of a source image changes but the file name stays the same, the cached images will not be updated automatically until the cache expires.
To force a revalidation, you can either:

1.  change the image's file name
2.  move it into another subdirectory, which will change its path
3.  change the [version number](/available-options#version) in the options (e.g., `version=2`)
4.  or flush the entire cache of your application using the `php artisan cache:clear` command.

## Cache Size Limit

The image caching feature also includes a size limit to prevent the cache from growing indefinitely. The default maximum size is **100 MB**, but you can change this in the configuration file.

When the cache reaches the specified size limit, it automatically cleans up old files to make space for new ones.

You may also configure the percentage of the maximum size that should be kept after cleanup, referred to as `clear_to_percent`.
For example, if `clear_to_percent` is set to 80, 20% of the cache is cleared on each cleanup run, and 80% is retained. The default is set to 80% of the maximum size.

---

You can configure the caching options in the `image-transform-url.php` configuration file:

```php
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
```
