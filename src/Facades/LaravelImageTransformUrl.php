<?php

namespace AceOfAces\LaravelImageTransformUrl\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AceOfAces\LaravelImageTransformUrl\LaravelImageTransformUrl
 */
class LaravelImageTransformUrl extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \AceOfAces\LaravelImageTransformUrl\LaravelImageTransformUrl::class;
    }
}
