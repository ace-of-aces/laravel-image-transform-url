# Getting started

Now it's time to test your first image transformation!

Use the following URL format to transform your images:

```ansi
http://[96m<domain>[39m/[31m<route-prefix>[39m/[95m<source-directory>[39m/[94m<options>[39m/[93m<path-to-your-image<.jpg|.jpeg|.png|.gif|.webp>>
```

> [!TIP]
> You can omit the `<source-directory>` part if you have set a default source directory in the configuration file.

For example:

```ansi
http://[96mlocalhost:8000[39m/[31mimage-transform[39m/[94mwidth=250,quality=80,format=webp[39m/[93mfoo/bar/example.jpg
```

With a `source-directory`:

```ansi
http://[96mlocalhost:8000[39m/[31mimage-transform[39m/[95mimages[39m/[94mwidth=250,quality=80,format=webp[39m/[93mfoo/bar/example.jpg
```

## Programmatic URL Generation

While you can construct URLs manually when needed, the package provides convenient methods to generate transformation URLs programmatically using the `ImageTransformUrl` facade.

Use the `make()` method to generate regular transformation URLs:

```php
use AceOfAces\LaravelImageTransformUrl\Facades\ImageTransformUrl;

// Generate a URL with array options
$url = ImageTransformUrl::make(
    'foo/example.jpg',
    ['width' => 250, 'quality' => 80, 'format' => 'webp'],
    'images'
);

// Generate a URL with string options
$url = ImageTransformUrl::make(
    'foo/example.jpg',
    'width=250,quality=80,format=webp',
    'images'
);

// Use default source directory (omit the third parameter)
$url = ImageTransformUrl::make(
    'foo/example.jpg',
    ['width' => 250, 'quality' => 80]
);
```

The `url()` method is also available as an alias for `make()`:

```php
$url = ImageTransformUrl::url('img/example.jpg', ['width' => 250]);
```

::: info
The facade also provides methods for [generating signed URLs](/signed-urls#generating-signed-urls).
:::
