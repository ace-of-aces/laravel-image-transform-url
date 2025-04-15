<?php

namespace AceOfAces\LaravelImageTransformUrl\Tests;

use AceOfAces\LaravelImageTransformUrl\LaravelImageTransformUrlServiceProvider;
use Illuminate\Contracts\Config\Repository;
use Intervention\Image\Laravel\ServiceProvider as InterventionImageServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use WithWorkbench;

    protected $loadEnvironmentVariables = false;

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

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        tap($app['config'], function (Repository $config) {
            $config->set('image-transform-url.public_path', 'test-data');
            $config->set('image-transform-url.enabled_options', [
                'width',
                'height',
                'blur',
                'contrast',
                'format',
            ]);
        });
    }
}
