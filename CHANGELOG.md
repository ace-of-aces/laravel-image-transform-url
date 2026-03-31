# Changelog

All notable changes to `laravel-image-transform-url` will be documented in this file.

## v2.0.0 - 2026-03-31

This release introduces compatibility for [Intervention Image v4](https://image.intervention.io/v4) as the underlying image processing library.

While there are no surface-level changes in this package, there are breaking changes in Intervention Image v4.

> [!IMPORTANT]
If your project uses Intervention Image directly, please review their [upgrade guide](https://image.intervention.io/v4/getting-started/upgrade).
Otherwise, no changes are required.

### What's Changed

* Migrate to Intervention Image v4 by @olivervogel in https://github.com/ace-of-aces/laravel-image-transform-url/pull/34
* chore(deps-dev): update ace-of-aces/intellipest requirement from ^0.2.0 to ^0.3.0 by @dependabot[bot] in https://github.com/ace-of-aces/laravel-image-transform-url/pull/28
* chore(deps): bump ramsey/composer-install from 3 to 4 by @dependabot[bot] in https://github.com/ace-of-aces/laravel-image-transform-url/pull/27
* chore(deps): bump pnpm/action-setup from 4 to 5 by @dependabot[bot] in https://github.com/ace-of-aces/laravel-image-transform-url/pull/29
* chore(deps): bump dependabot/fetch-metadata from 2.5.0 to 3.0.0 by @dependabot[bot] in https://github.com/ace-of-aces/laravel-image-transform-url/pull/32
* chore(deps): bump actions/configure-pages from 5 to 6 by @dependabot[bot] in https://github.com/ace-of-aces/laravel-image-transform-url/pull/31
* chore(deps): bump actions/deploy-pages from 4 to 5 by @dependabot[bot] in https://github.com/ace-of-aces/laravel-image-transform-url/pull/30

### New Contributors

* @olivervogel made their first contribution in https://github.com/ace-of-aces/laravel-image-transform-url/pull/34

**Full Changelog**: https://github.com/ace-of-aces/laravel-image-transform-url/compare/v1.3.1...v2.0.0

## v1.3.1 - 2026-02-28

### What's Changed

* Support Laravel 13 by @ace-of-aces in https://github.com/ace-of-aces/laravel-image-transform-url/pull/26

**Full Changelog**: https://github.com/ace-of-aces/laravel-image-transform-url/compare/v1.3.0...v1.3.1

## v1.3.0 - 2026-01-28

### What's Changed

* Architectural refactorings in 453eac2178a408632b1c3ab8f59326f0e0ff24cc and 08f00ad13e3a96063a29ba950a0d29d0f8e158ac. **No functional changes as long as you don't rely on undocumented internals of this package**.
* chore(deps): bump actions/checkout from 5 to 6 by @dependabot[bot] in https://github.com/ace-of-aces/laravel-image-transform-url/pull/24
* chore(deps): bump dependabot/fetch-metadata from 2.4.0 to 2.5.0 by @dependabot[bot] in https://github.com/ace-of-aces/laravel-image-transform-url/pull/25

**Full Changelog**: https://github.com/ace-of-aces/laravel-image-transform-url/compare/v1.2.0...v1.3.0

## v1.2.0 - 2025-11-23

### What's Changed

* Extend PHP version support with 8.3 and 8.5 by @ace-of-aces in https://github.com/ace-of-aces/laravel-image-transform-url/pull/23

**Docs**

* Updated a docs code snippet 23722625ddf6a7b6af848b2aa59532cbecf37308
* Updated the docs theme 💅🏻 c41e654baf5308ac7f3f7e050e1b70ebeb10315f

**Full Changelog**: https://github.com/ace-of-aces/laravel-image-transform-url/compare/v1.1.0...v1.2.0

## v1.1.0 - 2025-11-20

### What's Changed

* [Feat]: Guidelines for Laravel Boost by @ace-of-aces in https://github.com/ace-of-aces/laravel-image-transform-url/pull/22
* Updated `.gitattributes` which removes unnecessary files from the package installation b7c555cdb56071e451eddc003fdd17ecfb67c23b

**Full Changelog**: https://github.com/ace-of-aces/laravel-image-transform-url/compare/v1.0.1...v1.1.0

## v1.0.1 - 2025-11-17

### What's Changed

* fix: correct facade PHPDoc annotation for temporarySignedUrl 4082852272542fbe42dc33bb2d86f7a2e6ad8af6
* docs: use named parameters in code examples 0c54d9068ddc5b45101213a3000a46aa9fc93440
* docs: update links 8752beed70cb2e4049b2756d7647ea128a672c96
* chore(deps): bump actions/setup-node from 4 to 5 by @dependabot[bot] in https://github.com/ace-of-aces/laravel-image-transform-url/pull/19
* chore(deps): bump actions/setup-node from 5 to 6 by @dependabot[bot] in https://github.com/ace-of-aces/laravel-image-transform-url/pull/21
* chore(deps): bump stefanzweifel/git-auto-commit-action from 6 to 7 by @dependabot[bot] in https://github.com/ace-of-aces/laravel-image-transform-url/pull/20

**Full Changelog**: https://github.com/ace-of-aces/laravel-image-transform-url/compare/v1.0.0...v1.0.1

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
