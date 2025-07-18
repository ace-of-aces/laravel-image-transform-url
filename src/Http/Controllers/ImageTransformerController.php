<?php

declare(strict_types=1);

namespace AceOfAces\LaravelImageTransformUrl\Http\Controllers;

use AceOfAces\LaravelImageTransformUrl\Enums\AllowedMimeTypes;
use AceOfAces\LaravelImageTransformUrl\Enums\AllowedOptions;
use AceOfAces\LaravelImageTransformUrl\Traits\ManagesImageCache;
use AceOfAces\LaravelImageTransformUrl\Traits\ResolvesOptions;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Encoders\WebpEncoder;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\Encoders\GifEncoder;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Laravel\Facades\Image;

class ImageTransformerController extends \Illuminate\Routing\Controller
{
    use ManagesImageCache, ResolvesOptions;

    public function transformWithPrefix(Request $request, string $pathPrefix, string $options, string $path)
    {
        return $this->handleTransform($request, $pathPrefix, $options, $path);
    }

    public function transformDefault(Request $request, string $options, string $path)
    {
        return $this->handleTransform($request, null, $options, $path);
    }

    protected function handleTransform(Request $request, ?string $pathPrefix, string $options, ?string $path = null)
    {
        $realPath = $this->handlePath($pathPrefix, $path);

        $options = $this->parseOptions($options);

        // Check cache
        if (config()->boolean('image-transform-url.cache.enabled')) {
            $cachePath = $this->getCachePath($pathPrefix, $path, $options);

            if (File::exists($cachePath)) {
                if (Cache::has('image-transform-url:'.$cachePath)) {
                    // serve file from storage
                    return $this->imageResponse(
                        imageContent: File::get($cachePath),
                        mimeType: File::mimeType($cachePath),
                        cacheHit: true
                    );
                } else {
                    // Cache expired, delete the cache file and continue
                    File::delete($cachePath);
                }
            }
        }

        if (
            config()->boolean('image-transform-url.rate_limit.enabled') &&
            ! in_array(App::environment(), config()->array('image-transform-url.rate_limit.disabled_for_environments'))) {
            $this->rateLimit($request, $path);
        }

        $image = Image::read($realPath);

        if (Arr::hasAny($options, ['width', 'height'])) {
            $image->scale(
                $this->getPositiveIntOptionValue($options, 'width', $image->width() * 2),
                $this->getPositiveIntOptionValue($options, 'height', $image->height() * 2),
            );
        }

        if (Arr::has($options, 'blur')) {
            $image->blur($this->getPositiveIntOptionValue($options, 'blur', 100));
        }

        if (Arr::has($options, 'contrast')) {
            $image->contrast($this->getUnsignedIntOptionValue($options, 'contrast', 0, -100, 100));
        }

        if (Arr::has($options, 'flip')) {
            $flip = $this->getSelectOptionValue($options, 'flip', ['h', 'v', 'hv'], 'h');

            match ($flip) {
                'h' => $image->flip(),
                'v' => $image->flop(),
                'hv' => $image->flip()->flop(),
                default => null,
            };
        }

        if (Arr::has($options, 'background')) {
            $backgroundColor = $this->getStringOptionValue($options, 'background', 'ffffff');

            if (! preg_match('/^([a-f0-9]{6}|[a-f0-9]{3})$/', $backgroundColor)) {
                $backgroundColor = null;
            }

            if ($backgroundColor) {
                $image->blendTransparency($backgroundColor);
            }

        }

        // We use the mime type instead of the extension to determine the format, because this is more reliable.
        $originalMimetype = File::mimeType($realPath);

        $format = $this->getStringOptionValue($options, 'format', $originalMimetype);
        $quality = $this->getPositiveIntOptionValue($options, 'quality', 100, 100);

        $encoder = match ($format) {
            'png', 'image/png' => new PngEncoder,
            'webp', 'image/webp' => new WebpEncoder($quality),
            'jpeg', 'jpg', 'image/jpeg' => new JpegEncoder($quality),
            'gif', 'image/gif' => new GifEncoder,
            default => new AutoEncoder(quality: $quality),
        };

        $encoded = $image->encode($encoder);

        if (config()->boolean('image-transform-url.cache.enabled')) {
            defer(function () use ($pathPrefix, $path, $options, $encoded) {
                $this->storeCachedImage($pathPrefix, $path, $options, $encoded);
            });
        }

        return $this->imageResponse(
            imageContent: $encoded->toString(),
            mimeType: $encoded->mimetype(),
            cacheHit: false
        );

    }

    /**
     * Handle the path and ensure it is valid.
     */
    protected function handlePath(?string &$pathPrefix, ?string &$path): string
    {
        if ($path === null) {
            $path = $pathPrefix;
            $pathPrefix = null;
        }

        $allowedSourceDirectories = config('image-transform-url.source_directories', []);

        if (! $pathPrefix) {
            $pathPrefix = config('image-transform-url.default_source_directory') ?? array_key_first($allowedSourceDirectories);
        }

        abort_unless(array_key_exists($pathPrefix, $allowedSourceDirectories), 404);

        $basePath = $allowedSourceDirectories[$pathPrefix];
        $requestedPath = $basePath.'/'.$path;
        $realPath = realpath($requestedPath);

        abort_unless($realPath, 404);

        $allowedBasePath = realpath($basePath);
        abort_unless($allowedBasePath, 404);

        abort_unless(Str::startsWith($realPath, $allowedBasePath), 404);

        abort_unless(in_array(File::mimeType($realPath), AllowedMimeTypes::all(), true), 404);

        return $realPath;
    }

    /**
     * Rate limit the request.
     */
    protected function rateLimit(Request $request, string $path): void
    {
        $key = 'image-transform-url:'.$request->ip().':'.$path;

        $passed = RateLimiter::attempt(
            key: $key,
            maxAttempts: config()->integer('image-transform-url.rate_limit.max_attempts'),
            callback: fn () => true,
            decaySeconds: config()->integer('image-transform-url.rate_limit.decay_seconds'),
        );

        abort_unless($passed, 429, 'Too many requests. Please try again later.');
    }

    /**
     * Parse the given options.
     *
     * @return array<string, int>
     */
    protected static function parseOptions(string $options): array
    {
        /**
         *  The allowed options and their PHP types.
         *
         * @var array<string, string>
         */
        $allowedOptions = AllowedOptions::withTypes();

        $options = explode(',', $options);

        return collect($options)
            ->mapWithKeys(function ($option) {
                [$key] = explode('=', $option);

                $value = explode('=', $option)[1] ?? null;

                $value = is_numeric($value) ? (int) $value : $value;

                return [$key => $value];
            })
            ->filter(function ($value, $key) use ($allowedOptions) {
                return array_key_exists($key, $allowedOptions) && gettype($value) === $allowedOptions[$key];
            })->filter(function ($value, $key) {
                return in_array($key, config()->array('image-transform-url.enabled_options'), true);
            })->toArray();
    }

    /**
     * Respond with the image content.
     */
    protected static function imageResponse(string $imageContent, string $mimeType, bool $cacheHit = false): Response
    {
        return response($imageContent, 200, [
            'Content-Type' => $mimeType,
            ...(config()->boolean('image-transform-url.cache.enabled') ? [
                'X-Cache' => $cacheHit ? 'HIT' : 'MISS',
            ] : []),
            ...(config()->array('image-transform-url.headers')),
        ]);
    }
}
