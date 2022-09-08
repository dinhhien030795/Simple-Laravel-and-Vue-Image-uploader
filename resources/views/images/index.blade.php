<!DOCTYPE html>
<html lang="utf-8">
<head>
    <title>Image Uploading with Vue and Laravel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" />
    <meta name="csrf_token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="max-w-lg mx-auto mt-24">
        <h1 class="text-4xl font-bold text-center">Image Uploader</h1>
        <div id="app"></div>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
