<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Cache::flush();
    Storage::fake(config()->string('image-transform-url.cache.disk'));
});

it('responds with the configured headers', function () {

    // Set up the headers configuration
    config()->set('image-transform-url.headers', [
        'Cache-Control' => 'immutable, max-age=10000, public, s-maxage=10000',
        'X-Header' => 'Value',
    ]);

    $response = $this->get(route('image.transform.default', [
        'options' => 'width=500',
        'path' => 'cat.jpg',
    ]));

    $response->assertOk();
    $response->assertHeader('Cache-Control', 'immutable, max-age=10000, public, s-maxage=10000');
    $response->assertHeader('X-Header', 'Value');
});
