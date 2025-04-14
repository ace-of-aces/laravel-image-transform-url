<?php

declare(strict_types=1);

namespace AceOfAces\LaravelImageTransformUrl\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
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
        $publicPath = public_path($path);

        abort_if(File::missing($publicPath), 404);

        $options = $this->parseOptions($options);

        $image = Image::read($publicPath);

        if (Arr::hasAny($options, ['width', 'height'])) {
            $image->scale(
                $this->getIntOptionValue($options, 'width', $image->width()),
                $this->getIntOptionValue($options, 'height', $image->height()),
            );
        }

        // We use the mime type instead of the extension to determine the format, because this is more reliable.
        $originalMimetype = File::mimeType($publicPath);

        $format = $this->getStringOptionValue($options, 'format', $originalMimetype);
        $quality = $this->getIntOptionValue($options, 'quality', 100, 100);

        $encoder = match ($format) {
            'png', 'image/png' => new PngEncoder,
            'webp', 'image/webp' => new WebpEncoder($quality),
            'jpeg', 'jpg', 'image/jpeg' => new JpegEncoder($quality),
            'gif', 'image/gif' => new GifEncoder,
            default => new AutoEncoder(quality: $quality),
        };

        $encoded = $image->encode($encoder);

        return response($encoded, 200, [
            'Content-Type' => $encoded->mimetype(),
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
        $allowedOptions = [
            'width' => 'integer',
            'height' => 'integer',
            'format' => 'string',
            'quality' => 'integer',
            // TODO: add more options
        ];

        $options = explode(',', $options);

        return collect($options)
            ->mapWithKeys(function ($option) {
                [$key, $value] = explode('=', $option);

                $value = is_numeric($value) ? (int) $value : $value;

                return [$key => $value];
            })
            ->filter(function ($value, $key) use ($allowedOptions) {
                return array_key_exists($key, $allowedOptions) && gettype($value) === $allowedOptions[$key];
            })->toArray();
    }

    /**
     * Get the int value of the given option (if it exists).
     */
    protected static function getIntOptionValue(array $options, string $option, ?int $max = null, ?int $fallback = null): ?int
    {
        return min(
            Arr::get($options, $option, $fallback),
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
}
