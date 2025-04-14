<?php

namespace AceOfAces\LaravelImageTransformUrl\Tests;

use AceOfAces\LaravelImageTransformUrl\LaravelImageTransformUrlServiceProvider;
use Intervention\Image\Laravel\ServiceProvider as InterventionImageServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use WithWorkbench;

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

    protected function getEnvironmentSetUp($app)
    {
        $app->register(InterventionImageServiceProvider::class);
    }
}
