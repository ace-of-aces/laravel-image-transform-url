<?php

namespace AceOfAces\LaravelImageTransformUrl;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Workbench\App\View\Components\AdaptiveImage;

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
            ->hasRoute('image')
            ->hasViewComponent('adaptive-image', AdaptiveImage::class);
    }
}
