<?php

declare(strict_types=1);

namespace AceOfAces\LaravelImageTransformUrl\Http\Controllers;

use AceOfAces\LaravelImageTransformUrl\Actions\TransformImageAction;
use AceOfAces\LaravelImageTransformUrl\Traits\HasImageResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ImageTransformDefaultController extends \Illuminate\Routing\Controller
{
    use HasImageResponse;

    /**
     * Transform an image with a specified path prefix and custom options.
     */
    public function __invoke(Request $request, string $options, string $path, TransformImageAction $action): Response
    {
        $result = $action->handle($request->ip(), null, $options, $path);

        return $this->imageResponse($result);
    }
}
