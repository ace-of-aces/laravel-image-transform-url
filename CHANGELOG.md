# Changelog

All notable changes to `laravel-image-transform-url` will be documented in this file.

## v1.0.0 🚀 - 2025-09-06

### v1.0.0 - Stable Release! 🎉

#### What's Changed

* [Fix] Replace GD specific WebpEncoder with general WebpEncoder by @ace-of-aces in https://github.com/ace-of-aces/laravel-image-transform-url/pull/17
* [Docs + Test] Properly support multiple image drivers by @ace-of-aces in https://github.com/ace-of-aces/laravel-image-transform-url/pull/18
* [Docs] Added vite-plugin-llms: https://github.com/ace-of-aces/laravel-image-transform-url/commit/f3da2f9955c9ffcd08f2657b2cd088c28e2765ac
* [Docs] wording improvements: https://github.com/ace-of-aces/laravel-image-transform-url/commit/30a22db1824623d4c0063f6b4f3213a5e8c62c62
* chore(deps): bump actions/checkout from 4 to 5 by @dependabot[bot] in https://github.com/ace-of-aces/laravel-image-transform-url/pull/14
* chore(deps): bump actions/upload-pages-artifact from 3 to 4 by @dependabot[bot] in https://github.com/ace-of-aces/laravel-image-transform-url/pull/15

**Full Changelog**: https://github.com/ace-of-aces/laravel-image-transform-url/compare/v0.9.0...v1.0.0

## v0.9.0 - 2025-08-13

### What's Changed

* [Feat]: S3 Support by @ace-of-aces in https://github.com/ace-of-aces/laravel-image-transform-url/pull/13

**Full Changelog**: https://github.com/ace-of-aces/laravel-image-transform-url/compare/v0.8.0...v0.9.0

## v0.8.0 - 2025-08-06

### What's Changed

* [Feat]: Added support for programatically generating unsigned URLs in https://github.com/ace-of-aces/laravel-image-transform-url/commit/33d88768cff092b224301d6c0c72e2502941b43d
* chore(deps): bump aglipanci/laravel-pint-action from 2.5 to 2.6 by @dependabot[bot] in https://github.com/ace-of-aces/laravel-image-transform-url/pull/12

**Full Changelog**: https://github.com/ace-of-aces/laravel-image-transform-url/compare/v0.7.1...v0.8.0

## v0.7.0 - 2025-07-20

In this version, the planned URL signing feature has been added.

**⚠️ Potential breaking change:**
Renamed the service provider from `LaravelImageTransformUrlServiceProvider` to `ImageTransformUrlServiceProvider`.
Code changes should only necessary when a custom service provider registration is being used.

### What's Changed

* [Feature]: Signed URLs by @ace-of-aces in https://github.com/ace-of-aces/laravel-image-transform-url/pull/11

**Full Changelog**: https://github.com/ace-of-aces/laravel-image-transform-url/compare/v0.6.0...v0.7.0

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
