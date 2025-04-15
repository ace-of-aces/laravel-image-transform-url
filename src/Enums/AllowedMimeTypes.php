<?php

declare(strict_types=1);

namespace AceOfAces\LaravelImageTransformUrl\Enums;

enum AllowedMimeTypes: string
{
    case Jpeg = 'image/jpeg';
    case Png = 'image/png';
    case Webp = 'image/webp';
    case Gif = 'image/gif';

    public static function all(): array
    {
        return array_map(fn (self $mimeType) => $mimeType->value, self::cases());
    }
}
