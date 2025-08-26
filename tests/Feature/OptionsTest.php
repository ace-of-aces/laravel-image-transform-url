<?php

declare(strict_types=1);

use AceOfAces\LaravelImageTransformUrl\Tests\TestCase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Cache::flush();
    Storage::fake(config()->string('image-transform-url.cache.disk'));
});

it('can process the height option', function () {
    /** @var TestCase $this */
    $route = route('image.transform.default', [
        'options' => 'width=100',
        'path' => 'cat.jpg',
    ]);

    $response = $this->get($route);

    expect($response)->toBeImage([
        'width' => 100,
        'mime' => 'image/jpeg',
    ]);

    $page = visit($route)->on()->macbook14();

    $page->assertScreenshotMatches();
});

it('can process the width option', function () {
    /** @var TestCase $this */
    $route = route('image.transform.default', [
        'options' => 'height=100',
        'path' => 'cat.jpg',
    ]);

    $response = $this->get($route);

    expect($response)->toBeImage([
        'height' => 100,
        'mime' => 'image/jpeg',
    ]);

    $page = visit($route)->on()->macbook14();

    $page->assertScreenshotMatches();
});

it('can process the format option', function () {
    /** @var TestCase $this */
    $route = route('image.transform.default', [
        'options' => 'format=webp',
        'path' => 'cat.jpg',
    ]);

    $response = $this->get($route);

    expect($response)->toBeImage([
        'mime' => 'image/webp',
    ]);

    $page = visit($route)->on()->macbook14();

    $page->assertScreenshotMatches();
});

it('can process the quality option', function () {
    /** @var TestCase $this */
    $route = route('image.transform.default', [
        'options' => 'quality=50',
        'path' => 'cat.jpg',
    ]);

    $response = $this->get($route);

    expect($response)->toBeImage([
        'mime' => 'image/jpeg',
    ]);

    $page = visit($route)->on()->macbook14();

    $page->assertScreenshotMatches();
});

it('can process the blur option', function () {
    /** @var TestCase $this */
    $route = route('image.transform.default', [
        'options' => 'blur=20',
        'path' => 'cat.jpg',
    ]);

    $response = $this->get($route);

    expect($response)->toBeImage([
        'mime' => 'image/jpeg',
    ]);

    $page = visit($route)->on()->macbook14();

    $page->assertScreenshotMatches();
});

it('can process the flip option', function () {
    $route = route('image.transform.default', [
        'options' => 'flip=hv',
        'path' => 'cat.jpg',
    ]);

    $response = $this->get($route);

    expect($response)->toBeImage([
        'mime' => 'image/jpeg',
    ]);

    $page = visit($route)->on()->macbook14();

    $page->assertScreenshotMatches();
});

it('can process the contrast option', function () {
    /** @var TestCase $this */
    $route = route('image.transform.default', [
        'options' => 'contrast=-50',
        'path' => 'cat.jpg',
    ]);

    $response = $this->get($route);

    expect($response)->toBeImage([
        'mime' => 'image/jpeg',
    ]);

    $page = visit($route)->on()->macbook14();

    $page->assertScreenshotMatches();
});

it('can process the background option', function () {
    /** @var TestCase $this */
    $route = route('image.transform.default', [
        'options' => 'background=ffaa00',
        'path' => 'octocat.png',
    ]);

    $response = $this->get($route);

    expect($response)->toBeImage([
        'mime' => 'image/png',
    ]);

    $page = visit($route)->on()->macbook14();

    $page->assertScreenshotMatches();
});

it('can process multiple options at once', function () {
    /** @var TestCase $this */
    $route = route('image.transform.default', [
        'options' => 'width=100,format=gif,quality=50',
        'path' => 'cat.jpg',
    ]);

    $response = $this->get($route);

    expect($response)->toBeImage([
        'width' => 100,
        'mime' => 'image/gif',
    ]);

    $page = visit($route)->on()->macbook14();

    $page->assertScreenshotMatches();
});

it('can handle a trailing comma in options', function () {
    /** @var TestCase $this */
    $route = route('image.transform.default', [
        'options' => 'width=100,',
        'path' => 'cat.jpg',
    ]);

    $response = $this->get($route);

    expect($response)->toBeImage([
        'width' => 100,
        'mime' => 'image/jpeg',
    ]);

    $page = visit($route)->on()->macbook14();

    $page->assertScreenshotMatches();
});
