# Changelog

All notable changes to `laravel-image-transform-url` will be documented in this file.

## v0.3.0 - 2025-04-21

This version fixes adds checks against a possible path traversal attack vector in the ImageTransformerController.
Any real possibilities of this could not be detected, but this adds an additional safeguard.

## v0.2.0 - 2025-04-20

This version fixes an issue with the default configuration file using the `app()` helper, causing a binding resolution issue when published.

New configuration option:

- added a new `rate_limit.disabled_for_environments` configuration option in replacement to the `app()->isProduction()` helper on `rate_limit.enabled`

## v0.1.0 - 2025-04-19

Initial Release 🎉
