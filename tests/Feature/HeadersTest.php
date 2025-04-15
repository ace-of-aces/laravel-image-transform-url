<?php

declare(strict_types=1);

use AceOfAces\LaravelImageTransformUrl\Tests\TestCase;

beforeEach(function () {
    Cache::flush();
    Storage::fake('local');
});

it('responds with the configured headers', function () {

    // Set up the headers configuration
    config()->set('image-transform-url.headers', [
        'Cache-Control' => 'immutable, max-age=10000, public, s-maxage=10000',
        'X-Header' => 'Value',
    ]);

    /** @var TestCase $this */
    $response = $this->get(route('image.transform', [
        'options' => 'width=500',
        'path' => 'cat.jpg',
    ]));

    $response->assertOk();
    $response->assertHeader('Cache-Control', 'immutable, max-age=10000, public, s-maxage=10000');
    $response->assertHeader('X-Header', 'Value');
});
