<?php

namespace AceOfAces\LaravelImageTransformUrl\Tests;

use AceOfAces\LaravelImageTransformUrl\LaravelImageTransformUrlServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelImageTransformUrlServiceProvider::class,
        ];
    }
}
