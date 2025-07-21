<?php

declare(strict_types=1);

namespace AceOfAces\LaravelImageTransformUrl\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AceOfAces\LaravelImageTransformUrl\LaravelImageTransformUrl;
 *
 * @method static string signedUrl(string $path, array|string $options = [], ?string $pathPrefix = null, \DateTimeInterface|\DateInterval|int|null $expiration = null, ?bool $absolute = true)
 * @method static string temporarySignedUrl(string $path, array|string $options = [], \DateTimeInterface|\DateInterval|int $expiration, ?string $pathPrefix = null, ?bool $absolute = true)
 */
class ImageTransformUrl extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \AceOfAces\LaravelImageTransformUrl\ImageTransformUrl::class;
    }
}
