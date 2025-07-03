# Changelog

All notable changes to `laravel-image-transform-url` will be documented in this file.

## v0.6.0 - 2025-07-03

This version introduces a new cache size limit, enabled by default. More info in the [documentation](https://image-transform-url.julian.center/image-caching#cache-size-limit).

### What's Changed

* [Enhancement] improve requirements and installation instructions by @ace-of-aces in https://github.com/ace-of-aces/laravel-image-transform-url/pull/5
* [Feature]: New Documentation 💅🏻 by @ace-of-aces in https://github.com/ace-of-aces/laravel-image-transform-url/pull/6
* chore(deps): bump actions/configure-pages from 4 to 5 by @dependabot in https://github.com/ace-of-aces/laravel-image-transform-url/pull/8
* chore(deps): bump pnpm/action-setup from 3 to 4 by @dependabot in https://github.com/ace-of-aces/laravel-image-transform-url/pull/7
* [Feature]: Cache Size Limit by @ace-of-aces in https://github.com/ace-of-aces/laravel-image-transform-url/pull/9

**Full Changelog**: https://github.com/ace-of-aces/laravel-image-transform-url/compare/v0.5.0...v0.6.0

## v0.5.0 - 2025-06-20

This version introduces breaking changes in how the image source configuration works.
This allows for multiple source directories to be defined, as well as fixing storage support.

### What's Changed

* BREAKING: Introduced new `source_directories` and `default_source_directory` configuration options that replace the `public_path` option. Please adjust the `image-transform-url.php` configuration accordingly, or re-publish the vendor config file.
* fixes: https://github.com/ace-of-aces/laravel-image-transform-url/issues/3
* chore(deps): bump stefanzweifel/git-auto-commit-action from 5 to 6 by @dependabot in https://github.com/ace-of-aces/laravel-image-transform-url/pull/2

**Full Changelog**: https://github.com/ace-of-aces/laravel-image-transform-url/compare/v0.4.0...v0.5.0

## v0.4.0 - 2025-05-30

This version adds a new `background` option which can be used to set a HEX color to transparent areas of png images.

## v0.3.0 - 2025-04-21

This version fixes adds checks against a possible path traversal attack vector in the ImageTransformerController.
Any real possibilities of this could not be detected, but this adds an additional safeguard.

## v0.2.0 - 2025-04-20

This version fixes an issue with the default configuration file using the `app()` helper, causing a binding resolution issue when published.

New configuration option:

- added a new `rate_limit.disabled_for_environments` configuration option in replacement to the `app()->isProduction()` helper on `rate_limit.enabled`

## v0.1.0 - 2025-04-19

Initial Release 🎉
