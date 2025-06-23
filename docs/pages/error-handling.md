# Error Handling

The route handler of this package is designed to be robust against invalid options, paths and file names, while also not exposing additional information of your applications public directory structure.

This is why the route handler will return a plain `404` response if:

-   a requested image does not exist at the specified path
-   the requested image is not a valid image file
-   the provided options are not in the correct format (`key=value`, no trailing comma, etc.)

The only other HTTP error that can be returned is a `429` response, which indicates that the request was rate-limited.

If parts of the given route options are invalid, the route handler will ignore them and only apply the valid options.

Example:

```ansi
http://localhost:8000/image-transform/width=250,[31mquality=foo[39m,format=webp/example.jpg
```

will be processed as:

```ansi
http://localhost:8000/image-transform/width=250,format=webp/example.jpg
```
