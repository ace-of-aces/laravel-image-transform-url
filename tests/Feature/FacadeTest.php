<?php

declare(strict_types=1);

use AceOfAces\LaravelImageTransformUrl\Exceptions\InvalidConfigurationException;
use AceOfAces\LaravelImageTransformUrl\Facades\ImageTransformUrl;
use AceOfAces\LaravelImageTransformUrl\Tests\TestCase;

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
