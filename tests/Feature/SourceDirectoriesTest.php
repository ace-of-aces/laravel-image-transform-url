<?php

declare(strict_types=1);

use AceOfAces\LaravelImageTransformUrl\Tests\TestCase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Cache::flush();
    Storage::fake(config()->string('image-transform-url.cache.disk'));
    Storage::fake('public');
});

it('can serve from the storage directory', function () {

    $imagePath = 'images/test.jpg';
    Storage::disk('public')->put($imagePath, file_get_contents(__DIR__.'/../../workbench/test-data/cat.jpg'));

    $response = $this->get(route('image.transform', [
        'options' => 'width=100',
        'pathPrefix' => 'storage',
        'path' => 'images/test.jpg',
    ]));

    expect($response)->toBeImage([
        'width' => 100,
        'mime' => 'image/jpeg',
    ]);
});

it('can use the storage directory as the default source directory', function () {
    /** @var TestCase $this */
    config()->set('image-transform-url.default_source_directory', 'storage');

    $imagePath = 'images/test.jpg';
    Storage::disk('public')->put($imagePath, file_get_contents(__DIR__.'/../../workbench/test-data/cat.jpg'));

    $response = $this->get(route('image.transform.default', [
        'options' => 'width=100',
        'path' => 'images/test.jpg',
    ]));

    expect($response)->toBeImage([
        'width' => 100,
        'mime' => 'image/jpeg',
    ]);
});
