<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <script>
        (function() {
            const THEME_KEY = "theme";
            const DEFAULT_THEME = "light";

            const getCookie = (name) => {
                const value = `; ${document.cookie}`;
                const parts = value.split(`; ${name}=`);
                if (parts.length === 2) return parts.pop().split(";").shift();
                return null;
            };

            const getTheme = () => getCookie(THEME_KEY) || DEFAULT_THEME;

            const applyTheme = (theme) => {
                document.documentElement.setAttribute("data-theme", theme);
                document.documentElement.style.backgroundColor =
                    theme === "dark" ? "#1d232a" : "#f3f4f6";
            };

            // Apply theme immediately
            applyTheme(getTheme());
        })();
    </script>

</head>

<body>
    <x-shopowner-navigation />

    <div class="min-h-screen bg-base-100">
        {{ $slot }}
    </div>

    <x-shopowner-footer />

</body>

</html>
