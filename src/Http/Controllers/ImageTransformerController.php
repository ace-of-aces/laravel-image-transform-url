<?php

declare(strict_types=1);

namespace AceOfAces\LaravelImageTransformUrl\Http\Controllers;

use AceOfAces\LaravelImageTransformUrl\Enums\AllowedMimeTypes;
use AceOfAces\LaravelImageTransformUrl\Enums\AllowedOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Encoders\WebpEncoder;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\Encoders\GifEncoder;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Laravel\Facades\Image;

class ImageTransformerController extends \Illuminate\Routing\Controller
{
    public function __invoke(Request $request, string $options, string $path)
    {
        $pathPrefix = config()->string('image-transform-url.public_path');

        $publicPath = public_path($pathPrefix.'/'.$path);

        abort_if(File::missing($publicPath), 404);

        abort_if(! in_array(File::mimeType($publicPath), AllowedMimeTypes::all(), true), 404);

        $options = $this->parseOptions($options);

        // Check cache
        if (config()->boolean('image-transform-url.cache.enabled')) {
            $cachePath = $this->getCachePath($path, $options);

            if (File::exists($cachePath)) {
                if (Cache::has('image-transform-url:'.$cachePath)) {
                return response(File::get($cachePath), 200, [
                    'Content-Type' => File::mimeType($cachePath),
                    'X-Cache' => 'HIT',
                ]);
                } else {
                    // Cache expired, delete the cache file and continue
                    File::delete($cachePath);
                }
            }
        }

        $image = Image::read($publicPath);

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

        // We use the mime type instead of the extension to determine the format, because this is more reliable.
        $originalMimetype = File::mimeType($publicPath);

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
            defer(function () use ($path, $options, $encoded) {

                $cachePath = $this->getCachePath($path, $options);

                $cacheDir = dirname($cachePath);

                File::ensureDirectoryExists($cacheDir);
                File::put($cachePath, $encoded);

                Cache::put(
                    key: 'image-transform-url:'.$cachePath,
                    value: true,
                    ttl: config()->integer('image-transform-url.cache.lifetime'),
                );
            });
        }

        return response($encoded, 200, [
            'Content-Type' => $encoded->mimetype(),
            ...(config()->boolean('image-transform-url.cache.enabled') ? [
                'X-Cache' => 'MISS',
            ] : []),
        ]);

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
                [$key, $value] = explode('=', $option);

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
     * Get the positive int value of the given option (if it exists).
     */
    protected static function getPositiveIntOptionValue(array $options, string $option, ?int $max = null, ?int $fallback = null): ?int
    {
        $value = min(
            Arr::get($options, $option, $fallback),
            $max ?? PHP_INT_MAX,
        );

        return $value > 0 ? $value : null;
    }

    /**
     * Get the unsigned int value of the given option (if it exists).
     */
    protected static function getUnsignedIntOptionValue(array $options, string $option, ?int $fallback = null, ?int $min = null, ?int $max = null): ?int
    {
        return min(
            max(
                Arr::get($options, $option, $fallback),
                $min ?? PHP_INT_MIN,
            ),
            $max ?? PHP_INT_MAX,
        );
    }

    /**
     * Get the string value of the given option (if it exists).
     */
    protected function getStringOptionValue(array $options, string $option, ?string $default = null): ?string
    {
        return Arr::get($options, $option, $default);

    }

    /**
     * Get the select option value of the given option (if it exists).
     *
     * @param  array<string>  $allowedValues
     */
    protected function getSelectOptionValue(array $options, string $option, array $allowedValues, ?string $default = null): ?string
    {
        $value = Arr::get($options, $option, $default);

        return in_array($value, $allowedValues, true) ? $value : null;
    }

    /**
     * Get the cache path for the given path and options.
     */
    protected function getCachePath(string $path, array $options): string
    {
        $pathPrefix = config()->string('image-transform-url.public_path');

        return Storage::disk('local')->path('_cache/image-transform-url/'.$pathPrefix.'/'.json_encode($options).'_'.$path);
    }
}
