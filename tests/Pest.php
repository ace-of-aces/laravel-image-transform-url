<?php

use AceOfAces\LaravelImageTransformUrl\Tests\TestCase;
use Illuminate\Testing\TestResponse;
use Intervention\Gif\Exceptions\NotReadableException;
use Intervention\Image\Laravel\Facades\Image;

uses(TestCase::class)->in(__DIR__);

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet
| certain conditions. Pest provides a fluent API for writing assertions
| starting with "expect()". You may add your own assertions to Pests
| expectation API via the extend method.
|
*/

expect()->extend('toBeImage', function (array $options = []) {
    // $this->value here is the value passed to expect(), which should be a TestResponse
    if (! $this->value instanceof TestResponse) {
        throw new InvalidArgumentException('Value passed to toBeImage() must be an instance of Illuminate\Testing\TestResponse.');
    }

    /** @var TestResponse $response */
    $response = $this->value;

    // Basic checks
    $response->assertOk();

    if (isset($options['mime'])) {
        $response->assertHeader('Content-Type', $options['mime']);
    }

    // Image content validation
    $imageContent = $response->getContent();

    if (empty($imageContent)) {
        return $this->fail('Response content is empty.');
    }

    try {
        $image = Image::read($imageContent);

        // Check dimensions if provided
        if (isset($options['width'])) {
            expect($image->width())->toBe($options['width'], "Expected image width to be {$options['width']} but got {$image->width()}.");
        }
        if (isset($options['height'])) {
            expect($image->height())->toBe($options['height'], "Expected image height to be {$options['height']} but got {$image->height()}.");
        }

        return $this;

    } catch (NotReadableException $e) {
        return $this->fail('Response content is not a readable image: '.$e->getMessage());
    }
});
