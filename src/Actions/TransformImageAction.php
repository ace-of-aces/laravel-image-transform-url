<?php

declare(strict_types=1);

namespace AceOfAces\LaravelImageTransformUrl\Actions;

use AceOfAces\LaravelImageTransformUrl\Concerns\ManagesImageCache;
use AceOfAces\LaravelImageTransformUrl\Concerns\ResolvesOptions;
use AceOfAces\LaravelImageTransformUrl\Enums\AllowedMimeTypes;
use AceOfAces\LaravelImageTransformUrl\Enums\AllowedOptions;
use AceOfAces\LaravelImageTransformUrl\ValueObjects\ImageResult;
use AceOfAces\LaravelImageTransformUrl\ValueObjects\ImageSource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\Encoders\GifEncoder;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\Laravel\Facades\Image;

class TransformImageAction
{
    use ManagesImageCache, ResolvesOptions;

    /**
     * Handle the image transformation.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function handle(?string $ip, ?string $pathPrefix, string $options, ?string $path = null): ImageResult
    {
        $source = $this->handlePath($pathPrefix, $path);

        $options = $this->parseOptions($options);

        if (config()->boolean('image-transform-url.cache.enabled')) {
            $cachePath = $this->getCachePath($pathPrefix, $path, $options);

            if (File::exists($cachePath)) {
                if (Cache::has('image-transform-url:'.$cachePath)) {
                    return new ImageResult(
                        content: File::get($cachePath),
                        mimeType: File::mimeType($cachePath),
                        cacheHit: true
                    );
                } else {
                    File::delete($cachePath);
                }
            }
        }

        if (
            config()->boolean('image-transform-url.rate_limit.enabled') &&
            ! in_array(App::environment(), config()->array('image-transform-url.rate_limit.disabled_for_environments'))
        ) {
            $this->rateLimit($ip, $path);
        }

        $image = match ($source->type) {
            'disk' => Image::read(Storage::disk($source->disk)->get($source->path)),
            default => Image::read($source->path),
        };

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

        $originalMimetype = $source->mime;

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

        return new ImageResult(
            content: $encoded->toString(),
            mimeType: $encoded->mimetype(),
            cacheHit: false
        );
    }

    /**
     * Handle the path and ensure it is valid.
     *
     * @param-out string $pathPrefix
     */
    protected function handlePath(?string &$pathPrefix, ?string &$path): ImageSource
    {
        if ($path === null) {
            $path = $pathPrefix;
        }

        if (is_null($pathPrefix)) {
            $pathPrefix = config()->string('image-transform-url.default_source_directory', (string) array_key_first(config()->array('image-transform-url.source_directories')));
        }

        $allowedSourceDirectories = config()->array('image-transform-url.source_directories', []);

        abort_unless(array_key_exists($pathPrefix, $allowedSourceDirectories), 404);

        $base = $allowedSourceDirectories[$pathPrefix];

        // Handle disk-based source directories
        if (is_array($base) && array_key_exists('disk', $base)) {

            $disk = (string) $base['disk'];
            $prefix = isset($base['prefix']) ? trim((string) $base['prefix'], '/') : '';

            $normalized = $this->normalizeRelativePath($path);
            abort_unless(! is_null($normalized), 404);

            $diskPath = trim($prefix !== '' ? $prefix.'/'.$normalized : $normalized, '/');

            abort_unless(Storage::disk($disk)->exists($diskPath), 404);

            /** @var \Illuminate\Filesystem\FilesystemAdapter $diskAdapter */
            $diskAdapter = Storage::disk($disk);
            $mime = $diskAdapter->mimeType($diskPath);

            abort_unless(in_array($mime, AllowedMimeTypes::all(), true), 404);

            return new ImageSource(
                type: 'disk',
                path: $diskPath,
                mime: $mime,
                disk: $disk,
            );
        }

        // Handle local filesystem paths
        $basePath = (string) $base;
        $requestedPath = rtrim($basePath, '/').'/'.$path;
        $realPath = realpath($requestedPath);

        abort_unless($realPath, 404);

        $allowedBasePath = realpath($basePath);
        abort_unless($allowedBasePath, 404);

        abort_unless(Str::startsWith($realPath, $allowedBasePath), 404);

        abort_unless(in_array(File::mimeType($realPath), AllowedMimeTypes::all(), true), 404);

        return new ImageSource(
            type: 'local',
            path: $realPath,
            mime: (string) File::mimeType($realPath),
        );
    }

    /**
     * Rate limit the attempt.
     */
    protected function rateLimit(?string $ip, string $path): void
    {
        $key = 'image-transform-url:'.$ip.':'.$path;

        $passed = RateLimiter::attempt(
            key: $key,
            maxAttempts: config()->integer('image-transform-url.rate_limit.max_attempts'),
            callback: fn () => true,
            decaySeconds: config()->integer('image-transform-url.rate_limit.decay_seconds'),
        );

        abort_unless($passed, 429, 'Too many requests. Please try again later.');
    }

    /**
     * Normalize a relative path by resolving `.` and `..` segments.
     * Returns null if the path escapes above the root.
     */
    protected function normalizeRelativePath(string $path): ?string
    {
        $path = str_replace('\\', '/', $path);
        $segments = array_filter(explode('/', $path), fn ($s) => $s !== '');
        $stack = [];

        foreach ($segments as $segment) {
            if ($segment === '.') {
                continue;
            }
            if ($segment === '..') {
                if (empty($stack)) {
                    return null;
                }
                array_pop($stack);

                continue;
            }
            $stack[] = $segment;
        }

        return implode('/', $stack);
    }

    /**
     * Parse the given options.
     *
     * @return array<string, int|string>
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
}
