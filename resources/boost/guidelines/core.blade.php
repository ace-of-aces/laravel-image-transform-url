## Laravel Image Transform URL

- Laravel Image Transform URL is a Laravel package for transforming images on-the-fly via URL parameters, similar to Cloudflare Images.
- Laravel Image Transform URL supports multiple transformation drivers, S3 storage, automatic caching, CDN integration and more.
- The available transformation options and their parameters can be found in the documentation linked below.
- Always use the `ImageTransformUrl` facade to generate URLs for transformed images.
- Laravel Image Transform URL documentation follows the `llms.txt` format for its docs website, hosted at `https://image-transform-url.julian.center/**`
- **Before implementing any features using Laravel Image Transform URL, use the `web-search` tool when available to get the latest docs for a specific feature. The available docs are listed in <available-docs>**

### Basic Usage Patterns
- Use the `ImageTransformUrl::make($path, $options, ?$pathPrefix)` method to create a URL for an image with transformations.
- Use the `ImageTransformUrl::signedUrl($path, $options, ?$pathPrefix)` or `ImageTransformUrl::temporarySignedUrl($path, $options, $expiration, ?$pathPrefix)` method to create a signed URL for an image with transformations.
- You may also create URLs manually by following the following URL structure: `http(s)://<domain>/<route-prefix>/<source-directory>/<options>/<image-path>`

<available-docs>
## Basics
- [**/installation.md] Installation Guide
- [**/setup.md] Package Setup and Configuration
- [**/getting-started.md] Basic Usage and Examples

## Options
- [**/configuring-options.md] Configuring Available Transformation Options
- [**/available-options.md] List of Available Transformation Options and Parameters

## Advanced
- [**/signed-urls.md] Setup and Usage of Signed URLs
- [**/image-caching.md] Image Caching Strategies and Configuration
- [**/rate-limiting.md] Rate Limiting for Image Requests
- [**/s3-usage.md] Using Amazon S3 Compatible Storage
- [**/cdn-usage.md] Usage with CDNs
- [**/error-handling.md] Error Handling and Fallbacks
</available-docs>
