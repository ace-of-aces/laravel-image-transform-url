<?php

declare(strict_types=1);

namespace AceOfAces\LaravelImageTransformUrl\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string make(string $path, array|string $options = [], ?string $pathPrefix = null)
 * @method static string url(string $path, array|string $options = [], ?string $pathPrefix = null)
 * @method static string signedUrl(string $path, array|string $options = [], ?string $pathPrefix = null, \DateTimeInterface|\DateInterval|int|null $expiration = null, ?bool $absolute = true)
 * @method static string temporarySignedUrl(string $path, array|string $options = [], \DateTimeInterface|\DateInterval|int $expiration, ?string $pathPrefix = null, ?bool $absolute = true)
 *
 * @see \AceOfAces\LaravelImageTransformUrl\ImageTransformUrl
 */
class ImageTransformUrl extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \AceOfAces\LaravelImageTransformUrl\ImageTransformUrl::class;
    }
}
