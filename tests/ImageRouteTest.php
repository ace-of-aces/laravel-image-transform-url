<?php

use AceOfAces\LaravelImageTransformUrl\Tests\TestCase;

beforeEach(function () {
    Cache::flush();
});

it('returns 404 for non-existent files', function () {
    /** @var TestCase $this */
    $response = $this->get(route('image.transform', [
        'options' => 'width=100',
        'path' => 'non-existent.jpg',
    ]));

    $response->assertNotFound();
});

it('returns 404 for non-image files', function () {
    /** @var TestCase $this */
    $response = $this->get(route('image.transform', [
        'options' => 'width=100',
        'path' => 'text.txt',
    ]));

    $response->assertNotFound();
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
        // TODO: add quality check
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
        // TODO: add blur check
    ]);
});

it('can process the flip option', function () {
    $response = $this->get(route('image.transform', [
        'options' => 'flip=hv',
        'path' => 'cat.jpg',
    ]));

    expect($response)->toBeImage([
        'mime' => 'image/jpeg',
        // TODO: add flip check
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
        // TODO: add contrast check
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
        // TODO: add more checks
    ]);
});

it('can serve from the cache after identical requests', function () {
    /** @var TestCase $this */
    $response = $this->get(route('image.transform', [
        'options' => 'width=500',
        'path' => 'cat.jpg',
    ]));

    $response->assertOk();
    $response->assertHeader('X-Cache', 'MISS');

    $secondResponse = $this->get(route('image.transform', [
        'options' => 'width=500',
        'path' => 'cat.jpg',
    ]));

    $response->assertOk();
    $secondResponse->assertHeader('X-Cache', 'HIT');
});
