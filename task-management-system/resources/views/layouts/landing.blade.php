<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-base-100">
    {{-- <div class="flex flex-col h-screen">
        <!-- Top Section - Welcome Text and Buttons (1/3 of screen) -->
        <div class="h-1/3 flex flex-col items-center justify-center px-16 py-16">
            <div class="text-center">
                <h1 class="text-6xl font-bold text-primary mb-4">Welcome</h1>
                <p class="text-xl text-base-content/70 mb-8">Phsar Khmer is with the you</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-8 rounded-full ">
                    Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline btn-lg px-8 rounded-full">
                    Register
                </a>
            </div>
        </div>

        <!-- Bottom Section - Laptop Image (2/3 of screen) -->
        <div class="h-2/3 flex items-center justify-center p-8">
            <div class="w-full max-w-4xl h-full">
                <img src="{{ Vite::asset('resources/images/laptop.png') }}" alt="Laptop"
                    class="w-full h-full object-contain" />
            </div>
        </div>
    </div> --}}
    {{ $slot }}
</body>

</html>
