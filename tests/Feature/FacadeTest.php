<?php

declare(strict_types=1);

use AceOfAces\LaravelImageTransformUrl\Exceptions\InvalidConfigurationException;
use AceOfAces\LaravelImageTransformUrl\Facades\ImageTransformUrl;
use AceOfAces\LaravelImageTransformUrl\Tests\TestCase;
use Illuminate\Support\Facades\URL;

it('produces identical signed URLs for the signedUrl and temporarySignedUrl methods when given the same parameters', function () {
    /** @var TestCase $this */
    config()->set('image-transform-url.signed_urls.enabled', true);

    $signedUrlOne = ImageTransformUrl::signedUrl(
        'path/to/image.jpg',
        ['width' => 100, 'height' => 200],
        'images',
        now()->addMinutes(60)
    );

    $signedUrlTwo = ImageTransformUrl::temporarySignedUrl(
        'path/to/image.jpg',
        ['width' => 100, 'height' => 200],
        now()->addMinutes(60),
        'images'
    );

    expect($signedUrlOne)->toBe($signedUrlTwo);
});

it('throws an exception when signed URLs are not enabled', function () {
    /** @var TestCase $this */
    config()->set('image-transform-url.signed_urls.enabled', false);

    ImageTransformUrl::signedUrl('path/to/image.jpg', ['width' => 100, 'height' => 200]);
})->throws(InvalidConfigurationException::class, 'Signed URLs are not enabled. Please check your configuration.');

it('can use the make method to generate a regular unsigned URL', function () {
    /** @var TestCase $this */
    $url = ImageTransformUrl::make('path/to/image.jpg', ['width' => 100, 'height' => 200], 'images');

    expect($url)->toBe(URL::route('image.transform', [
        'pathPrefix' => 'images',
        'options' => 'width=100,height=200',
        'path' => 'path/to/image.jpg',
    ]));
});

it('can use the url method as an alias for make', function () {
    /** @var TestCase $this */
    $url = ImageTransformUrl::url('path/to/image.jpg', ['width' => 100, 'height' => 200], 'images');

    expect($url)->toBe(ImageTransformUrl::make('path/to/image.jpg', ['width' => 100, 'height' => 200], 'images'));
});
