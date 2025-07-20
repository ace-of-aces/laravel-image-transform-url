<?php

declare(strict_types=1);

namespace AceOfAces\LaravelImageTransformUrl\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Routing\Middleware\ValidateSignature;
use Symfony\Component\HttpFoundation\Response;

class SignedImageTransformMiddleware
{
    /**
     * Handle an incoming request and conditionally apply signature verification.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $pathPrefix = $request->route('pathPrefix');

        if (is_null($pathPrefix)) {
            $pathPrefix = config()->string('image-transform-url.default_source_directory');
        }

        if ($this->requiresSignatureVerification($pathPrefix)) {
            return $this->validateSignature($request, $next);
        }

        return $next($request);
    }

    /**
     * Determine if signature verification is required for the given path prefix.
     */
    protected function requiresSignatureVerification(string $pathPrefix): bool
    {
        if (! config()->boolean('image-transform-url.signed_urls.enabled')) {
            return false;
        }

        $protectedDirectories = config()->array('image-transform-url.signed_urls.for_source_directories');

        return in_array($pathPrefix, $protectedDirectories, true);
    }

    /**
     * Validate the signature of the request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    protected function validateSignature(Request $request, Closure $next): Response
    {
        $validator = new ValidateSignature;

        try {
            return $validator->handle($request, $next);
        } catch (InvalidSignatureException $e) {
            throw $e;
        }
    }
}
