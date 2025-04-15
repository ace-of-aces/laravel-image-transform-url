<?php

declare(strict_types=1);

use AceOfAces\LaravelImageTransformUrl\Http\Controllers\ImageTransformerController;
use Illuminate\Support\Facades\Route;

Route::prefix(config()->string('image-transform-url.route_prefix'))->group(function () {
    Route::get('{options}/{path}', ImageTransformerController::class)
        ->where('options', '([a-zA-Z]+=-?[a-zA-Z0-9]+,?)+')
        ->where('path', '.*\..*')
        ->name('image.transform');
});
