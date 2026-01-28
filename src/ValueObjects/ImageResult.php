<?php

declare(strict_types=1);

namespace AceOfAces\LaravelImageTransformUrl\ValueObjects;

/**
 * @internal
 */
readonly class ImageResult
{
    public function __construct(
        public readonly string $content,
        public readonly string $mimeType,
        public readonly bool $cacheHit,
    ) {}
}
