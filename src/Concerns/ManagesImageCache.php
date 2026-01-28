<?php

declare(strict_types=1);

namespace AceOfAces\LaravelImageTransformUrl\Concerns;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Interfaces\EncodedImageInterface;

trait ManagesImageCache
{
    /**
     * Check if cache is within size limits and cleanup if necessary.
     */
    protected function manageCacheSize(): void
    {
        $maxSizeBytes = config()->integer('image-transform-url.cache.max_size_mb', 100) * 1024 * 1024;

        $disk = Storage::disk(config()->string('image-transform-url.cache.disk'));
        $cacheBasePath = '_cache/image-transform-url';

        if (! $disk->exists($cacheBasePath)) {
            return;
        }

        $currentSize = $this->calculateCacheSize($disk, $cacheBasePath);

        if ($currentSize <= $maxSizeBytes) {
            return;
        }

        $this->cleanupOldCacheFiles($disk, $cacheBasePath, $maxSizeBytes);
    }

    /**
     * Calculate the total size of the cache directory.
     */
    protected function calculateCacheSize(Filesystem $disk, string $cacheBasePath): int
    {
        $totalSize = 0;
        $files = $disk->allFiles($cacheBasePath);

        foreach ($files as $file) {
            $totalSize += $disk->size($file);
        }

        return $totalSize;
    }

    /**
     * Clean up old cache files to make room for new ones.
     */
    protected function cleanupOldCacheFiles(Filesystem $disk, string $cacheBasePath, int $maxSizeBytes): void
    {
        $files = $disk->allFiles($cacheBasePath);

        $fileInfo = [];

        foreach ($files as $file) {

            $fullPath = $disk->path($file);

            if ($disk->exists($file)) {
                $fileInfo[] = [
                    'path' => $file,
                    'full_path' => $fullPath,
                    'size' => $disk->size($file),
                    'modified' => $disk->lastModified($file),
                ];
            }
        }

        usort($fileInfo, fn ($a, $b) => $a['modified'] <=> $b['modified']);

        $currentSize = array_sum(array_column($fileInfo, 'size'));

        $clearToPercent = config()->integer('image-transform-url.cache.clear_to_percent', 80);
        $clearToPercent = max(0, min(99, $clearToPercent));

        $targetSize = (int) ($maxSizeBytes * ($clearToPercent / 100));

        foreach ($fileInfo as $file) {
            if ($currentSize <= $targetSize) {
                break;
            }

            $disk->delete($file['path']);

            $cacheKey = 'image-transform-url:'.$file['full_path'];
            Cache::forget($cacheKey);

            $currentSize -= $file['size'];
        }
    }

    /**
     * Store image in cache with size management.
     *
     * @param  array<string, int|string>  $options
     */
    protected function storeCachedImage(?string $pathPrefix, ?string $path, array $options, EncodedImageInterface $encoded): void
    {
        $cachePath = $this->getCachePath($pathPrefix, $path, $options);
        $disk = Storage::disk(config()->string('image-transform-url.cache.disk'));

        $endPath = $this->getCacheEndPath($pathPrefix, $path, $options);

        $disk->put($endPath, $encoded->toString());

        $this->manageCacheSize();

        Cache::put(
            key: 'image-transform-url:'.$cachePath,
            value: true,
            ttl: config()->integer('image-transform-url.cache.lifetime'),
        );
    }

    /**
     * Get the cache path for the given path and options.
     *
     * @param  array<string, int|string>  $options
     */
    protected function getCachePath(?string $pathPrefix, ?string $path, array $options): string
    {
        $cachePath = $this->getCacheEndPath($pathPrefix, $path, $options);

        return Storage::disk(config()->string('image-transform-url.cache.disk'))->path($cachePath);
    }

    /**
     * Get the end (relative) path for storing the cached image.
     *
     * @param  array<string, int|string>  $options
     */
    protected function getCacheEndPath(?string $pathPrefix, ?string $path, array $options): string
    {
        $optionsHash = md5(json_encode($options));

        return '_cache/image-transform-url/'.$pathPrefix.'/'.$optionsHash.'_'.$path;
    }
}
