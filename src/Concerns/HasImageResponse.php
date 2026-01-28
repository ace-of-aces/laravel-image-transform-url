<?php

declare(strict_types=1);

namespace AceOfAces\LaravelImageTransformUrl\Concerns;

use AceOfAces\LaravelImageTransformUrl\ValueObjects\ImageResult;
use Illuminate\Http\Response;

trait HasImageResponse
{
    /**
     * Respond with the image content.
     */
    protected static function imageResponse(ImageResult $result): Response
    {
        return response($result->content, 200, [
            'Content-Type' => $result->mimeType,
            ...(config()->boolean('image-transform-url.cache.enabled') ? [
                'X-Cache' => $result->cacheHit ? 'HIT' : 'MISS',
            ] : []),
            ...(config()->array('image-transform-url.headers')),
        ]);
    }
}
