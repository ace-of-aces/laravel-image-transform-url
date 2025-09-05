<?php

declare(strict_types=1);

use AceOfAces\LaravelImageTransformUrl\Facades\ImageTransformUrl;
use AceOfAces\LaravelImageTransformUrl\Tests\TestCase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Cache::flush();
    Storage::fake(config()->string('image-transform-url.cache.disk'));
});

function configureTestEnvironment(): void
{
    config()->set('image-transform-url.signed_urls.enabled', true);
    config()->set('image-transform-url.signed_urls.for_source_directories', ['protected']);
    config()->set('image-transform-url.source_directories.protected', Storage::fake('local')->path('protected'));
}

it('can protect a route with a signed URL', function () {
    /** @var TestCase $this */
    configureTestEnvironment();

    Storage::disk('local')->put('protected/cat.jpg', file_get_contents(public_path('images/cat.jpg')));

    assert(Storage::disk('local')->exists('protected/cat.jpg'));

    $response = $this->get(route('image.transform', [
        'pathPrefix' => 'protected',
        'options' => 'width=100',
        'path' => 'cat.jpg',
    ]));

    $response->assertStatus(403);

    $signedUrl = ImageTransformUrl::signedUrl('cat.jpg', [
        'width' => 100,
    ], 'protected');

    $secondResponse = $this->get($signedUrl);

    expect($secondResponse)->toBeImage([
        'mime' => 'image/jpeg',
    ]);
});

it('can protect a route with a temporary signed URL that expires', function () {
    /** @var TestCase $this */
    configureTestEnvironment();

    Storage::disk('local')->put('protected/cat.jpg', file_get_contents(public_path('images/cat.jpg')));

    assert(Storage::disk('local')->exists('protected/cat.jpg'));

    $signedUrl = ImageTransformUrl::signedUrl(
        'cat.jpg',
        ['width' => 100],
        'protected',
        now()->addMinutes(60),
    );

    $response = $this->get($signedUrl);

    expect($response)->toBeImage([
        'mime' => 'image/jpeg',
    ]);

    $this->travel(61)->minutes();

    $expiredResponse = $this->get($signedUrl);
    $expiredResponse->assertStatus(403);
});

it('cannot manipulate signatures to access images', function () {
    /** @var TestCase $this */
    configureTestEnvironment();

    Storage::disk('local')->put('protected/cat.jpg', file_get_contents(public_path('images/cat.jpg')));

    assert(Storage::disk('local')->exists('protected/cat.jpg'));

    $signedUrl = ImageTransformUrl::signedUrl('cat.jpg', [
        'width' => 100,
    ], 'protected');

    $manipulatedOptionsUrl = str_replace('width=100', 'width=500', $signedUrl);
    $manipulatedResponse = $this->get($manipulatedOptionsUrl);
    $manipulatedResponse->assertStatus(403);

    $manipulatedSignatureUrl = substr($signedUrl, 0, -5).'12345';
    $manipulatedSignatureResponse = $this->get($manipulatedSignatureUrl);
    $manipulatedSignatureResponse->assertStatus(403);
});

it('can use a protected directory as default source directory', function () {
    /** @var TestCase $this */
    configureTestEnvironment();

    config()->set('image-transform-url.default_source_directory', 'protected');

    Storage::disk('local')->put('protected/cat.jpg', file_get_contents(public_path('images/cat.jpg')));

    assert(Storage::disk('local')->exists('protected/cat.jpg'));

    $signedUrl = ImageTransformUrl::signedUrl('cat.jpg', [
        'width' => 100,
    ]);

    $response = $this->get($signedUrl);

    expect($response)->toBeImage([
        'mime' => 'image/jpeg',
    ]);
});

it('can still access an unprotected source directory without signed URLs', function () {
    /** @var TestCase $this */
    configureTestEnvironment();

    $response = $this->get(route('image.transform.default', [
        'options' => 'width=100',
        'path' => 'cat.jpg',
    ]));

    expect($response)->toBeImage([
        'mime' => 'image/jpeg',
    ]);
});
