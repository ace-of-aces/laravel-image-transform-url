<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

beforeEach(function () {
    Cache::flush();
    Storage::fake(config()->string('image-transform-url.cache.disk'));
})->with([
    function () {
        config()->set('image.driver', Driver::class);

        return 'gd';
    },
    function () {
        config()->set('image.driver', Intervention\Image\Drivers\Imagick\Driver::class);

        return 'imagick';
    },
    function () {
        if (PHP_OS_FAMILY === 'Windows') {
            test()->markTestSkipped('The Vips driver is not available on Windows CI.');
        }

        config()->set('image.driver', Intervention\Image\Drivers\Vips\Driver::class);

        return 'vips';
    },
]);

it('can process the height option', function () {
    $response = $this->get(route('image.transform.default', [
        'options' => 'width=100',
        'path' => 'cat.jpg',
    ]));

    expect($response)->toBeImage([
        'width' => 100,
        'mime' => 'image/jpeg',
    ]);
});

it('can process the width option', function () {
    $response = $this->get(route('image.transform.default', [
        'options' => 'height=100',
        'path' => 'cat.jpg',
    ]));

    expect($response)->toBeImage([
        'height' => 100,
        'mime' => 'image/jpeg',
    ]);
});

it('can process the format option', function () {
    $response = $this->get(route('image.transform.default', [
        'options' => 'format=webp',
        'path' => 'cat.jpg',
    ]));

    expect($response)->toBeImage([
        'mime' => 'image/webp',
    ]);
});

it('can process the quality option', function () {
    $response = $this->get(route('image.transform.default', [
        'options' => 'quality=50',
        'path' => 'cat.jpg',
    ]));

    expect($response)->toBeImage([
        'mime' => 'image/jpeg',
    ]);
});

it('can process the blur option', function () {
    $response = $this->get(route('image.transform.default', [
        'options' => 'blur=20',
        'path' => 'cat.jpg',
    ]));

    expect($response)->toBeImage([
        'mime' => 'image/jpeg',
    ]);
});

it('can process the flip option', function () {
    $response = $this->get(route('image.transform.default', [
        'options' => 'flip=hv',
        'path' => 'cat.jpg',
    ]));

    expect($response)->toBeImage([
        'mime' => 'image/jpeg',
    ]);
});

it('can process the contrast option', function () {
    $response = $this->get(route('image.transform.default', [
        'options' => 'contrast=-50',
        'path' => 'cat.jpg',
    ]));

    expect($response)->toBeImage([
        'mime' => 'image/jpeg',
    ]);
});

it('can process the background option', function () {
    $response = $this->get(route('image.transform.default', [
        'options' => 'background=ffaa00',
        'path' => 'octocat.png',
    ]));

    expect($response)->toBeImage([
        'mime' => 'image/png',
    ]);
});

it('can process multiple options at once', function () {
    $response = $this->get(route('image.transform.default', [
        'options' => 'width=100,format=gif,quality=50',
        'path' => 'cat.jpg',
    ]));

    expect($response)->toBeImage([
        'width' => 100,
        'mime' => 'image/gif',
    ]);
});

it('can handle a trailing comma in options', function () {
    $response = $this->get(route('image.transform.default', [
        'options' => 'width=100,',
        'path' => 'cat.jpg',
    ]));

    expect($response)->toBeImage([
        'width' => 100,
        'mime' => 'image/jpeg',
    ]);
});
