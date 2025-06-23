# Available Options

These are the options that can be used to transform images with this package.

## `background`

`string`

Set the background color of the image.  
Any valid HEX color value (without a leading `#`).

Example:

```
background=ff0000
```

> [!IMPORTANT]
> Only supported for the `png` format.

## `blur`

`integer`

Set the blur level of the image.
Possible values: `0` to `100`.

Example:

```
blur=50
```

> [!CAUTION]
> The `blur` option is a resource-intensive operation and may cause memory issues if the image is too large. It is recommended to use this option with caution and test beforehand, or disable it in the config.

## `contrast`

`integer`

Set the contrast level of the image.  
Possible values: `-100` to `100`.

Example:

```
contrast=50
```

## `flip`

`string`

Flip the image.  
Possible values: `h` (horizontal), `v` (vertical), `hv` (horizontal and vertical).

Example:

```
flip=h
```

## `format`

`string`

Set the format of the image.  
Supported formats: `jpg`, `jpeg`, `png`, `gif`, `webp`.

Example:

```
format=webp
```

## `height`

`integer`

Set the height of the image.  
Values greater than the original height will be ignored.

Example:

```
height=250
```

## `quality`

`integer`

Set the quality of the image.  
Possible values: `0` to `100`.

Example:

```
quality=80
```

## `version`

`integer`

Version number of the image.  
Any positive integer. More info in the [Image Caching](/image-caching) section.

Example:

```
version=2
```

## `width`

`integer`

Set the width of the image.  
Values greater than the original width will be ignored.

Example:

```
width=250
```
