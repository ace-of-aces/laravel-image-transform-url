<?php

declare(strict_types=1);

use AceOfAces\LaravelImageTransformUrl\Tests\TestCase;

beforeEach(function () {
    Cache::flush();
    Storage::fake(config()->string('image-transform-url.cache.disk'));
});

it('can apply rate limiting to image transformation requests with distinct options', function () {
    // Set up the rate limit configuration
    config()->set('image-transform-url.rate_limit.enabled', true);
    // Enable for this test by not setting 'testing' in the disabled_for_environments array
    config()->set('image-transform-url.rate_limit.disabled_for_environments', [
        'local',
    ]);
    config()->set('image-transform-url.rate_limit.max_attempts', 2);
    config()->set('image-transform-url.rate_limit.decay_seconds', 60);

    /** @var TestCase $this */
    $firstResponse = $this->get(route('image.transform', [
        'options' => 'width=100',
        'path' => 'cat.jpg',
    ]));

    expect($firstResponse)->toBeImage([
        'width' => 100,
        'mime' => 'image/jpeg',
    ]);

    $secondResponse = $this->get(route('image.transform', [
        'options' => 'width=200',
        'path' => 'cat.jpg',
    ]));

    expect($secondResponse)->toBeImage([
        'width' => 200,
        'mime' => 'image/jpeg',
    ]);

    $thirdResponse = $this->get(route('image.transform', [
        'options' => 'width=300',
        'path' => 'cat.jpg',
    ]));

    $thirdResponse->assertTooManyRequests();
});

it('does not apply rate limiting to image transformations with identical options', function () {
    // Set up the rate limit configuration
    config()->set('image-transform-url.rate_limit.enabled', true);
    config()->set('image-transform-url.rate_limit.max_attempts', 2);
    config()->set('image-transform-url.rate_limit.decay_seconds', 60);

    /** @var TestCase $this */
    $firstResponse = $this->get(route('image.transform', [
        'options' => 'width=100',
        'path' => 'cat.jpg',
    ]));

    expect($firstResponse)->toBeImage([
        'width' => 100,
        'mime' => 'image/jpeg',
    ]);

    $secondResponse = $this->get(route('image.transform', [
        'options' => 'width=100',
        'path' => 'cat.jpg',
    ]));

    expect($secondResponse)->toBeImage([
        'width' => 100,
        'mime' => 'image/jpeg',
    ]);

    $thirdResponse = $this->get(route('image.transform', [
        'options' => 'width=100',
        'path' => 'cat.jpg',
    ]));

    expect($thirdResponse)->toBeImage([
        'width' => 100,
        'mime' => 'image/jpeg',
    ]);
});
