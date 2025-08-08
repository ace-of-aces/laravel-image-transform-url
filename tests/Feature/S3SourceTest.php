<?php

declare(strict_types=1);

use AceOfAces\LaravelImageTransformUrl\Tests\TestCase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Cache::flush();
    Storage::fake(config()->string('image-transform-url.cache.disk'));
    Storage::fake('s3');

    // Configure S3 as a source directory using the disk driver
    config()->set('image-transform-url.source_directories.s3', [
        'disk' => 's3',
        'prefix' => '',
    ]);
});

it('can serve from an s3 disk source directory', function () {
    /** @var TestCase $this */
    $imagePath = 'images/test.jpg';
    Storage::disk('s3')->put($imagePath, file_get_contents(__DIR__.'/../../workbench/test-data/cat.jpg'));

    $response = $this->get(route('image.transform', [
        'options' => 'width=100',
        'pathPrefix' => 's3',
        'path' => $imagePath,
    ]));

    expect($response)->toBeImage([
        'width' => 100,
        'mime' => 'image/jpeg',
    ]);
});

it('can use s3 as the default source directory', function () {
    /** @var TestCase $this */
    config()->set('image-transform-url.default_source_directory', 's3');

    $imagePath = 'images/test.jpg';
    Storage::disk('s3')->put($imagePath, file_get_contents(__DIR__.'/../../workbench/test-data/cat.jpg'));

    $response = $this->get(route('image.transform.default', [
        'options' => 'width=100',
        'path' => $imagePath,
    ]));

    expect($response)->toBeImage([
        'width' => 100,
        'mime' => 'image/jpeg',
    ]);
});
