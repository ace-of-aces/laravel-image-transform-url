<?php

declare(strict_types=1);

namespace AceOfAces\LaravelImageTransformUrl;

use AceOfAces\LaravelImageTransformUrl\Exceptions\InvalidConfigurationException;
use DateInterval;
use DateTimeInterface;
use Illuminate\Support\Facades\URL;

class ImageTransformUrl
{
    /**
     * Generate a regular URL for the image transformation.
     *
     * @param  string  $path  The path to the image.
     * @param  array<string, int|string>|string  $options  The transformation options.
     * @param  string|null  $pathPrefix  The path prefix to use. Defaults to the default path prefix.
     * @return string The generated URL.
     */
    public function make(string $path, array|string $options = [], ?string $pathPrefix = null): string
    {
        $options = $this->optionsToString($options);

        if (empty($pathPrefix)) {
            return URL::route('image.transform.default', ['options' => $options, 'path' => $path]);
        }

        return URL::route('image.transform', ['pathPrefix' => $pathPrefix, 'options' => $options, 'path' => $path]);
    }

    /**
     * Generate a regular URL for the image transformation.
     *
     * @param  string  $path  The path to the image.
     * @param  array<string, int|string>|string  $options  The transformation options.
     * @param  string|null  $pathPrefix  The path prefix to use. Defaults to the default path prefix.
     * @return string The generated URL.
     */
    public function url(string $path, array|string $options = [], ?string $pathPrefix = null): string
    {
        return $this->make($path, $options, $pathPrefix);
    }

    /**
     * Generate a signed URL for the image transformation.
     *
     * @param  string  $path  The path to the image.
     * @param  array<string, int|string>|string  $options  The transformation options.
     * @param  string|null  $pathPrefix  The path prefix to use. Defaults to the default path prefix.
     * @param  DateTimeInterface|\DateInterval|int|null  $expiration  The expiration time for the signed URL.
     * @return string The signed URL.
     *
     * @throws InvalidConfigurationException If signed URLs are not enabled in the configuration.
     */
    public function signedUrl(string $path, array|string $options = [], ?string $pathPrefix = null, DateTimeInterface|DateInterval|int|null $expiration = null, ?bool $absolute = true): string
    {
        if (! config()->boolean('image-transform-url.signed_urls.enabled')) {
            throw new InvalidConfigurationException('Signed URLs are not enabled. Please check your configuration.');
        }

        $options = $this->optionsToString($options);

        if (empty($pathPrefix)) {
            return URL::signedRoute(
                'image.transform.default',
                ['options' => $options, 'path' => $path],
                $expiration,
                $absolute
            );
        }

        return URL::signedRoute(
            'image.transform',
            ['pathPrefix' => $pathPrefix, 'options' => $options, 'path' => $path],
            $expiration,
            $absolute
        );
    }

    /**
     * Generate a temporary signed URL for the image transformation.
     *
     * @param  string  $path  The path to the image.
     * @param  array<string, int|string>|string  $options  The transformation options.
     * @param  DateTimeInterface|DateInterval|int  $expiration  The expiration time for the signed URL.
     * @param  string|null  $pathPrefix  The path prefix to use. Defaults to the default path prefix.
     * @param  bool|null  $absolute  Whether the URL should be absolute. Defaults to true.
     * @return string The temporary signed URL.
     *
     * @throws InvalidConfigurationException If signed URLs are not enabled in the configuration.
     */
    public function temporarySignedUrl(string $path, array|string $options, DateTimeInterface|DateInterval|int $expiration, ?string $pathPrefix, ?bool $absolute = true): string
    {
        return $this->signedUrl($path, $options, $pathPrefix, $expiration, $absolute);
    }

    /**
     * Convert array options to a string format suitable for URL generation.
     *
     * @param  array<string, int|string>|string  $options
     */
    protected function optionsToString(array|string $options): string
    {
        if (is_array($options)) {
            return collect($options)
                ->map(fn ($value, $key) => "$key=$value")
                ->implode(',');
        }

        return $options;
    }
}
