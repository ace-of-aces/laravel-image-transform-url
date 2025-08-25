<?php

declare(strict_types=1);

namespace AceOfAces\LaravelImageTransformUrl\Exceptions;

use RuntimeException;
use Throwable;

class InvalidConfigurationException extends RuntimeException
{
    public function __construct(string $message, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
