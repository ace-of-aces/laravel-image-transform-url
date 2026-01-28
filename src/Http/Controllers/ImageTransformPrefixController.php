<?php

declare(strict_types=1);

namespace AceOfAces\LaravelImageTransformUrl\Http\Controllers;

use AceOfAces\LaravelImageTransformUrl\Actions\TransformImageAction;
use AceOfAces\LaravelImageTransformUrl\Concerns\HasImageResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ImageTransformPrefixController extends \Illuminate\Routing\Controller
{
    use HasImageResponse;

    /**
     * Transform an image with the default path prefix and custom options.
     */
    public function __invoke(Request $request, string $pathPrefix, string $options, string $path, TransformImageAction $action): Response
    {
        $result = $action->handle($request->ip(), $pathPrefix, $options, $path);

        return $this->imageResponse($result);
    }
}
