<?php

declare(strict_types=1);

use AceOfAces\LaravelImageTransformUrl\Tests\TestCase;

beforeEach(function () {
    Cache::flush();
    Storage::fake(config()->string('image-transform-url.cache.disk'));
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

it('can use the version option to revalidate the cache', function () {
    /** @var TestCase $this */
    $response = $this->get(route('image.transform', [
        'options' => 'version=1',
        'path' => 'cat.jpg',
    ]));

    $response->assertOk();
    $response->assertHeader('X-Cache', 'MISS');

    $sameVersionResponse = $this->get(route('image.transform', [
        'options' => 'version=1',
        'path' => 'cat.jpg',
    ]));

    $sameVersionResponse->assertOk();
    $sameVersionResponse->assertHeader('X-Cache', 'HIT');

    $differentVersionResponse = $this->get(route('image.transform', [
        'options' => 'version=2',
        'path' => 'cat.jpg',
    ]));

    $differentVersionResponse->assertOk();
    $differentVersionResponse->assertHeader('X-Cache', 'MISS');
});
