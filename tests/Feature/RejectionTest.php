<?php

declare(strict_types=1);

use AceOfAces\LaravelImageTransformUrl\Tests\TestCase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Cache::flush();
    Storage::fake(config()->string('image-transform-url.cache.disk'));
});

it('returns 404 for non-existent files', function () {
    /** @var TestCase $this */
    $response = $this->get(route('image.transform.default', [
        'options' => 'width=100',
        'path' => 'non-existent.jpg',
    ]));

    $response->assertNotFound();
});

it('returns 404 for non-image files', function () {
    /** @var TestCase $this */
    $response = $this->get(route('image.transform.default', [
        'options' => 'width=100',
        'path' => 'text.txt',
    ]));

    $response->assertNotFound();
});
