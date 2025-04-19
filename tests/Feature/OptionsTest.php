<?php

declare(strict_types=1);

use AceOfAces\LaravelImageTransformUrl\Tests\TestCase;

beforeEach(function () {
    Cache::flush();
    Storage::fake(config()->string('image-transform-url.cache.disk'));
});

it('can process the height option', function () {
    /** @var TestCase $this */
    $response = $this->get(route('image.transform', [
        'options' => 'width=100',
        'path' => 'cat.jpg',
    ]));

    expect($response)->toBeImage([
        'width' => 100,
        'mime' => 'image/jpeg',
    ]);
});

it('can process the width option', function () {
    /** @var TestCase $this */
    $response = $this->get(route('image.transform', [
        'options' => 'height=100',
        'path' => 'cat.jpg',
    ]));

    expect($response)->toBeImage([
        'height' => 100,
        'mime' => 'image/jpeg',
    ]);
});

it('can process the format option', function () {
    /** @var TestCase $this */
    $response = $this->get(route('image.transform', [
        'options' => 'format=webp',
        'path' => 'cat.jpg',
    ]));

    expect($response)->toBeImage([
        'mime' => 'image/webp',
    ]);
});

it('can process the quality option', function () {
    /** @var TestCase $this */
    $response = $this->get(route('image.transform', [
        'options' => 'quality=50',
        'path' => 'cat.jpg',
    ]));

    expect($response)->toBeImage([
        'mime' => 'image/jpeg',
    ]);
});

it('can process the blur option', function () {
    /** @var TestCase $this */
    $response = $this->get(route('image.transform', [
        'options' => 'blur=20',
        'path' => 'cat.jpg',
    ]));

    expect($response)->toBeImage([
        'mime' => 'image/jpeg',
    ]);
});

it('can process the flip option', function () {
    $response = $this->get(route('image.transform', [
        'options' => 'flip=hv',
        'path' => 'cat.jpg',
    ]));

    expect($response)->toBeImage([
        'mime' => 'image/jpeg',
    ]);
});

it('can process the contrast option', function () {
    /** @var TestCase $this */
    $response = $this->get(route('image.transform', [
        'options' => 'contrast=-50',
        'path' => 'cat.jpg',
    ]));

    expect($response)->toBeImage([
        'mime' => 'image/jpeg',
    ]);
});

it('can process multiple options at once', function () {
    /** @var TestCase $this */
    $response = $this->get(route('image.transform', [
        'options' => 'width=100,format=gif,quality=50',
        'path' => 'cat.jpg',
    ]));

    expect($response)->toBeImage([
        'width' => 100,
        'mime' => 'image/gif',
    ]);
});

it('can handle a trailing comma in options', function () {
    /** @var TestCase $this */
    $response = $this->get(route('image.transform', [
        'options' => 'width=100,',
        'path' => 'cat.jpg',
    ]));

    expect($response)->toBeImage([
        'width' => 100,
        'mime' => 'image/jpeg',
    ]);
});
