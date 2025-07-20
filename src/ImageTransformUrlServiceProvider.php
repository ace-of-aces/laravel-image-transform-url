<?php

declare(strict_types=1);

namespace AceOfAces\LaravelImageTransformUrl;

use AceOfAces\LaravelImageTransformUrl\Http\Middleware\SignedImageTransformMiddleware;
use Illuminate\Routing\Router;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ImageTransformUrlServiceProvider extends PackageServiceProvider
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
            ->hasRoute('image');
    }

    public function packageBooted(): void
    {
        $this->registerMiddleware();
    }

    /**
     * Register the custom middleware.
     */
    protected function registerMiddleware(): void
    {
        $router = $this->app->make(Router::class);

        $router->aliasMiddleware('signed-image-transform', SignedImageTransformMiddleware::class);
    }
}
