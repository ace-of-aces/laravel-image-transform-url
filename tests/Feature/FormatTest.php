<?php

declare(strict_types=1);

use AceOfAces\LaravelImageTransformUrl\Enums\AllowedMimeTypes;
use AceOfAces\LaravelImageTransformUrl\Tests\TestCase;

beforeEach(function () {
    Cache::flush();
    Storage::fake(config()->string('image-transform-url.cache.disk'));
});

it('can convert from jpeg to all other allowed mime types', function () {
    $allowedMimeTypes = collect(AllowedMimeTypes::withExtension())->filter(
        fn ($allowed) => $allowed['mime'] !== 'image/jpeg'
    );

    foreach ($allowedMimeTypes as $allowed) {
        /** @var TestCase $this */
        $response = $this->get(route('image.transform', [
            'options' => 'format='.$allowed['extension'],
            'path' => 'cat.jpg',
        ]));

        expect($response)->toBeImage([
            'mime' => $allowed['mime'],
        ]);
    }
});

it('can convert from gif to all other allowed mime types', function () {
    $allowedMimeTypes = collect(AllowedMimeTypes::withExtension())->filter(
        fn ($allowed) => $allowed['mime'] !== 'image/gif'
    );

    foreach ($allowedMimeTypes as $allowed) {
        /** @var TestCase $this */
        $response = $this->get(route('image.transform', [
            'options' => 'format='.$allowed['extension'],
            'path' => 'cat-kiss.gif',
        ]));

        expect($response)->toBeImage([
            'mime' => $allowed['mime'],
        ]);
    }
});

it('can convert from png to all other allowed mime types', function () {
    $allowedMimeTypes = collect(AllowedMimeTypes::withExtension())->filter(
        fn ($allowed) => $allowed['mime'] !== 'image/png'
    );

    foreach ($allowedMimeTypes as $allowed) {
        /** @var TestCase $this */
        $response = $this->get(route('image.transform', [
            'options' => 'format='.$allowed['extension'],
            'path' => 'cat.png',
        ]));

        expect($response)->toBeImage([
            'mime' => $allowed['mime'],
        ]);
    }
});
it('can convert from webp to all other allowed mime types', function () {
    $allowedMimeTypes = collect(AllowedMimeTypes::withExtension())->filter(
        fn ($allowed) => $allowed['mime'] !== 'image/webp'
    );

    foreach ($allowedMimeTypes as $allowed) {
        /** @var TestCase $this */
        $response = $this->get(route('image.transform', [
            'options' => 'format='.$allowed['extension'],
            'path' => 'cat.webp',
        ]));

        expect($response)->toBeImage([
            'mime' => $allowed['mime'],
        ]);
    }
});
