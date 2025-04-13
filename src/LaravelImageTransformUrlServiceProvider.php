<?php

namespace AceOfAces\LaravelImageTransformUrl;

use AceOfAces\LaravelImageTransformUrl\Commands\LaravelImageTransformUrlCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelImageTransformUrlServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-image-transform-url')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_image_transform_url_table')
            ->hasCommand(LaravelImageTransformUrlCommand::class);
    }
}
