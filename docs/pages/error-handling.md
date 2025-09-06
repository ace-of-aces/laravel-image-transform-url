# Error Handling

The route handler of this package is designed to be robust against invalid options, paths, and file names, while also not exposing additional information about your application's public directory structure.

## HTTP Status Codes

For this reason, the route handler returns a plain `404` response if:

-   the requested image does not exist at the specified path
-   the requested file is not a valid image
-   the provided options are not in the correct format (`key=value`, no trailing comma, etc.)

The only two other HTTP errors that can be returned are:
- a `429` response, which indicates that the request was rate-limited
- a `403` response, which indicates that the request was unauthorized (e.g., when using signed URLs and the signature is invalid or expired)

## Invalid options

If parts of the given route options are invalid, the route handler ignores them and applies only the valid options.

Example:

```ansi
http://localhost:8000/image-transform/width=250,[31mquality=foo[39m,format=webp/example.jpg
```

will be processed as:

```ansi
http://localhost:8000/image-transform/width=250,format=webp/example.jpg
```
