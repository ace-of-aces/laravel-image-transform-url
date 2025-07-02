<?php

declare(strict_types=1);

use AceOfAces\LaravelImageTransformUrl\Tests\TestCase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Cache::flush();
    Storage::fake(config()->string('image-transform-url.cache.disk'));
});

it('can serve from the cache after identical requests', function () {
    /** @var TestCase $this */
    $response = $this->get(route('image.transform.default', [
        'options' => 'width=500',
        'path' => 'cat.jpg',
    ]));

    $response->assertOk();
    $response->assertHeader('X-Cache', 'MISS');

    $secondResponse = $this->get(route('image.transform.default', [
        'options' => 'width=500',
        'path' => 'cat.jpg',
    ]));

    $response->assertOk();
    $secondResponse->assertHeader('X-Cache', 'HIT');
});

it('can use the version option to revalidate the cache', function () {
    /** @var TestCase $this */
    $response = $this->get(route('image.transform.default', [
        'options' => 'version=1',
        'path' => 'cat.jpg',
    ]));

    $response->assertOk();
    $response->assertHeader('X-Cache', 'MISS');

    $sameVersionResponse = $this->get(route('image.transform.default', [
        'options' => 'version=1',
        'path' => 'cat.jpg',
    ]));

    $sameVersionResponse->assertOk();
    $sameVersionResponse->assertHeader('X-Cache', 'HIT');

    $differentVersionResponse = $this->get(route('image.transform.default', [
        'options' => 'version=2',
        'path' => 'cat.jpg',
    ]));

    $differentVersionResponse->assertOk();
    $differentVersionResponse->assertHeader('X-Cache', 'MISS');
});

it('can disable the cache', function () {
    /** @var TestCase $this */
    config()->set('image-transform-url.cache.enabled', false);

    for($i = 0; $i < 2; $i++) {
        $response = $this->get(route('image.transform.default', [
            'options' => 'width=500',
            'path' => 'cat.jpg',
        ]));

        $response->assertOk();
        $response->assertHeaderMissing('X-Cache');
    }
});

it('can manage cache size limit by cleaning up old files', function () {
    /** @var TestCase $this */
    // Set a high cache size limit first
    config()->set('image-transform-url.cache.max_size_mb', 100);

    $responses = [];
    $totalSizeMB = 0;

    // Fill up the cache with some images
    for ($i = 0; $i < 10; $i++) {
        $response = $this->get(route('image.transform.default', [
            'options' => "width=1200,version={$i}",
            'path' => 'cat.jpg',
        ]));

        $disk = Storage::disk(config()->string('image-transform-url.cache.disk'));
        $size = $disk->size($this->getCacheEndPath('test-data', 'cat.jpg', ['width' => 1200, 'version' => $i]));

        $totalSizeMB += $size / (1024 * 1024);

        $response->assertOk();
        $response->assertHeader('X-Cache', 'MISS');

        $responses[] = $response;
    }

    // Set the used cache size as the upper limit, so we can test the cleanup
    config()->set('image-transform-url.cache.max_size_mb', (int) ceil($totalSizeMB));

    // Create one more image that should trigger cache cleanup
    $finalResponse = $this->get(route('image.transform.default', [
        'options' => 'width=2400,version=99',
        'path' => 'cat.jpg',
    ]));

    $finalResponse->assertOk();
    $finalResponse->assertHeader('X-Cache', 'MISS');

    $disk = Storage::disk(config()->string('image-transform-url.cache.disk'));

    expect($disk->exists('_cache/image-transform-url'))->toBeTrue();

    $allFiles = $disk->allFiles('_cache/image-transform-url');

    $totalSizeAfterClearMB = 0;

    foreach ($allFiles as $filePath) {
        $size = $disk->size($filePath);
        $totalSizeAfterClearMB += $size / (1024 * 1024);
    }

    $maxAfterClearSizeMB = config()->integer('image-transform-url.cache.max_size_mb') * (config()->integer('image-transform-url.cache.clear_to_percent') / 100);

    expect($totalSizeAfterClearMB)->toBeLessThanOrEqual($maxAfterClearSizeMB);
});

it('deletes files in the right order when cleaning up the cache', function () {
    /** @var TestCase $this */
    config()->set('image-transform-url.cache.max_size_mb', 100);

    $responses = [];
    $cacheFilePaths = [];
    $totalSizeMB = 0;

    // Fill up the cache with some images
    for ($i = 0; $i < 10; $i++) {
        $response = $this->get(route('image.transform.default', [
            'options' => "width=1200,version={$i}",
            'path' => 'cat.jpg',
        ]));

        $disk = Storage::disk(config()->string('image-transform-url.cache.disk'));
        $endPath = $this->getCacheEndPath('test-data', 'cat.jpg', ['width' => 1200, 'version' => $i]);

        $cacheFilePaths[] = $endPath;

        $size = $disk->size($endPath);

        $totalSizeMB += $size / (1024 * 1024);

        $response->assertOk();
        $response->assertHeader('X-Cache', 'MISS');

        $responses[] = $response;

        usleep(50_000);
    }

    $disk = Storage::disk(config()->string('image-transform-url.cache.disk'));

    expect($disk->exists('_cache/image-transform-url'))->toBeTrue();

    // Set the used cache size as the upper limit, so we can test the cleanup
    config()->set('image-transform-url.cache.max_size_mb', (int) $totalSizeMB);

    // Create one more image that should trigger cache cleanup
    $finalResponse = $this->get(route('image.transform.default', [
        'options' => 'width=2400,version=99',
        'path' => 'cat.jpg',
    ]));

    $lastCacheFilePath = $this->getCacheEndPath('test-data', 'cat.jpg', ['width' => 2400, 'version' => 99]);

    $finalResponse->assertOk();
    $finalResponse->assertHeader('X-Cache', 'MISS');

    expect($disk->exists('_cache/image-transform-url'))->toBeTrue();

    expect($disk->exists($lastCacheFilePath))->toBeTrue(); // The last file should still exist

    expect($disk->exists($cacheFilePaths[0]))->toBeFalse(); // The oldest file should at be deleted
});
