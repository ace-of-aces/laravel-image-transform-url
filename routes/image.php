<?php

declare(strict_types=1);

use AceOfAces\LaravelImageTransformUrl\Http\Controllers\ImageTransformDefaultController;
use AceOfAces\LaravelImageTransformUrl\Http\Controllers\ImageTransformPrefixController;
use AceOfAces\LaravelImageTransformUrl\Http\Middleware\SignedImageTransformMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix(config()->string('image-transform-url.route_prefix'))->group(function () {
    // Explicit path prefix route
    Route::get('{pathPrefix}/{options}/{path}', ImageTransformPrefixController::class)
        ->where('pathPrefix', '[a-zA-Z][a-zA-Z0-9_-]*')
        ->where('options', '([a-zA-Z]+=-?[a-zA-Z0-9]+,?)+')
        ->where('path', '.*\..*')
        ->name('image.transform')
        ->middleware(SignedImageTransformMiddleware::class);

    // Default path prefix route
    Route::get('{options}/{path}', ImageTransformDefaultController::class)
        ->where('options', '([a-zA-Z]+=-?[a-zA-Z0-9]+,?)+')
        ->where('path', '.*\..*')
        ->name('image.transform.default')
        ->middleware(SignedImageTransformMiddleware::class);
});
