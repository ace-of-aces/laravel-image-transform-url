<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Image-Transform-URL Playground</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>

<body
    class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    <h1 class="text-white">Playground</h1>
    <img
        src="test-data/cat.png"
        srcset="
            image-transform/width=200/cat.png 200w,
            image-transform/width=400/cat.png 400w,
            image-transform/width=800/cat.png 800w,
            image-transform/width=1200/cat.png 1200w,
            image-transform/width=1920/cat.png 1920w
        "
        alt="Cat Image"
    />
</body>

</html>
