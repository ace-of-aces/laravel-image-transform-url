<?php

declare(strict_types=1);

use AceOfAces\LaravelImageTransformUrl\Http\Controllers\ImageTransformerController;
use Illuminate\Support\Facades\Route;

Route::prefix(config()->string('image-transform-url.route_prefix'))->group(function () {
    // Explicit path prefix route
    Route::get('{pathPrefix}/{options}/{path}', [ImageTransformerController::class, 'transformWithPrefix'])
        ->where('pathPrefix', '[a-zA-Z][a-zA-Z0-9_-]*')
        ->where('options', '([a-zA-Z]+=-?[a-zA-Z0-9]+,?)+')
        ->where('path', '.*\..*')
        ->name('image.transform');

    // Default path prefix route
    Route::get('{options}/{path}', [ImageTransformerController::class, 'transformDefault'])
        ->where('options', '([a-zA-Z]+=-?[a-zA-Z0-9]+,?)+')
        ->where('path', '.*\..*')
        ->name('image.transform.default');
});
