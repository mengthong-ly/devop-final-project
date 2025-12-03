<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-base-100">
    <div class="flex min-h-screen">
        <div class="flex items-center justify-center bg-base-100 p-[12px] w-1/2">
            <img src="{{ 'resources/images/background.jpg' }}" alt="Logo"
                class="w-full h-full object-cover rounded-lg shadow-xl" />
        </div>
        <div class="flex items-center justify-center bg-base-100 w-1/2">
            <div class ="w-1/2">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>
