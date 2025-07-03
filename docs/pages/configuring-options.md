# Configuring Options

This package supports a variety of options, but you may not need or want to use all of them. You can configure which options are enabled in the `image-transform-url.php` configuration file.

```php
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
    // 'flip',
    // 'contrast',
    // 'version',
    // 'background',
    // 'blur'
]),
```
