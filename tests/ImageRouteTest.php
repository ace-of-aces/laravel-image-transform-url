<?php

use AceOfAces\LaravelImageTransformUrl\Tests\TestCase;

it('doesn\'t work for non-existent files', function () {
    /** @var TestCase $this */
    $response = $this->get(route('image.transform', [
        'options' => 'width=100',
        'path' => 'non-existent.jpg',
    ]));

    $response->assertNotFound();
});

it('can process the height option', function () {
    /** @var TestCase $this */
    $response = $this->get(route('image.transform', [
        'options' => 'width=100',
        'path' => 'test-img/cat.jpg',
    ]));

    expect($response)->toBeImage([
        'width' => 100,
        'mime' => 'image/jpeg',
    ]);
});

it('can process the width option', function () {
    /** @var TestCase $this */
    $response = $this->get(route('image.transform', [
        'options' => 'height=100',
        'path' => 'test-img/cat.jpg',
    ]));

    expect($response)->toBeImage([
        'height' => 100,
        'mime' => 'image/jpeg',
    ]);
});

it('can process the format option', function () {
    /** @var TestCase $this */
    $response = $this->get(route('image.transform', [
        'options' => 'format=webp',
        'path' => 'test-img/cat.jpg',
    ]));

    expect($response)->toBeImage([
        'mime' => 'image/webp',
    ]);
});

it('can process the quality option', function () {
    /** @var TestCase $this */
    $response = $this->get(route('image.transform', [
        'options' => 'quality=50',
        'path' => 'test-img/cat.jpg',
    ]));

    expect($response)->toBeImage([
        'mime' => 'image/jpeg',
        //TODO: add quality check
    ]);
});

it('can process multiple options at once', function () {
    $response = $this->get(route('image.transform', [
        'options' => 'width=100,format=gif,quality=50',
        'path' => 'test-img/cat.jpg',
    ]));

    expect($response)->toBeImage([
        'width' => 100,
        'mime' => 'image/gif',
        //TODO: add quality check
    ]);
});
