# Setup

1. Configure the package via `image-transform-url.php` to set your `source_directories`, from where you want to transform the images. By default, the package will look for `images` directories in your `public` folder and in the `storage/app/public` directory.

2. Choose a default source directory by setting the `default_source_directory` option in the `image-transform-url.php` configuration file. This will be used if no source directory is specified in the URL.

> [!TIP]
> It is recommended to use dedicated subdirectories for your images in order to avoid conflicts with other files.

An example source directory configuration might look like this:

```php
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

    // ...
```
