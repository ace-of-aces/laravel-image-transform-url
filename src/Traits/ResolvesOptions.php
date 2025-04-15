<?php

declare(strict_types=1);

namespace AceOfAces\LaravelImageTransformUrl\Traits;

use Illuminate\Support\Arr;

trait ResolvesOptions
{
    /**
     * Get the positive int value of the given option.
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
     * Get the unsigned int value of the given option.
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
     * Get the string value of the given option.
     */
    protected static function getStringOptionValue(array $options, string $option, ?string $default = null): ?string
    {
        return Arr::get($options, $option, $default);

    }

    /**
     * Get the select option value of the given option.
     *
     * @param  array<string>  $allowedValues
     */
    protected static function getSelectOptionValue(array $options, string $option, array $allowedValues, ?string $default = null): ?string
    {
        $value = Arr::get($options, $option, $default);

        return in_array($value, $allowedValues, true) ? $value : null;
    }
}
