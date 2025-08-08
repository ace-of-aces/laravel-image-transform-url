# Usage with S3

This guide explains how to configure this package to work with S3-compatible storage services like AWS S3 or Cloudflare R2.
This enables you to transform and serve images stored remotely without the need to store images on your local server.

1. Set up your S3 disk in your [filesystems configuration](https://laravel.com/docs/filesystem#amazon-s3-compatible-filesystems), install the [S3 package](https://laravel.com/docs/filesystem#s3-driver-configuration) and ensure you have the necessary credentials and settings for your S3 bucket. Public bucket access is not required.

2. Configure the package via `image-transform-url.php` to include your S3 disk in the `source_directories` as described in [the setup guide](/setup#configuring-remote-sources).

3. If you are using the [Image Caching](/image-caching) feature and want to store transformed images back to your S3 bucket instead of your local filesystem, you may also set the `cache.disk` option in the `image-transform-url.php` configuration file to your S3 disk.

```php
'cache' => [
    //...
    'disk' => env('IMAGE_TRANSFORM_CACHE_DISK', 's3'),
    //...
],
```

::: warning
Having the `cache.disk` set to your S3 disk may result in higher latency and costs due to the nature of remote storage. If you are concerned about performance, consider using a local disk for caching and only use S3 for the source directories.
:::

4. You can now use the [image transformation URLs](/getting-started) as usual, and the package will handle fetching images from your S3 bucket.
