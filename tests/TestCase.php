<?php

namespace AceOfAces\LaravelImageTransformUrl\Tests;

use AceOfAces\LaravelImageTransformUrl\Enums\AllowedOptions;
use AceOfAces\LaravelImageTransformUrl\ImageTransformUrlServiceProvider;
use AceOfAces\LaravelImageTransformUrl\Traits\ManagesImageCache;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\ServiceProvider as InterventionImageServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use ManagesImageCache, WithWorkbench;

    protected $loadEnvironmentVariables = false;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            ImageTransformUrlServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app->register(InterventionImageServiceProvider::class);
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        tap($app['config'], function (Repository $config) {
            $config->set('image-transform-url.source_directories.storage', Storage::fake('public')->path(''));
            $config->set('image-transform-url.enabled_options', AllowedOptions::all());
        });
    }
}
