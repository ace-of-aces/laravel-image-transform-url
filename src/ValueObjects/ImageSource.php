<?php

declare(strict_types=1);

namespace AceOfAces\LaravelImageTransformUrl\ValueObjects;

/**
 * @internal
 */
readonly class ImageSource
{
    public function __construct(
        public readonly string $type,
        public readonly string $path,
        public readonly string $mime,
        public readonly ?string $disk = null,
    ) {
        if (! in_array($this->type, ['local', 'disk'], true)) {
            throw new \InvalidArgumentException('Invalid image source type provided.');
        }
    }
}
