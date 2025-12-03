<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        (function() {
            const THEME_KEY = "theme";
            const SIDEBAR_KEY = "sidebar-drawer";
            const DEFAULT_THEME = "light";

            const getCookie = (name) => {
                const value = `; ${document.cookie}`;
                const parts = value.split(`; ${name}=`);
                if (parts.length === 2) return parts.pop().split(";").shift();
                return null;
            };

            const getTheme = () => getCookie(THEME_KEY) || DEFAULT_THEME;
            const getSidebarDrawer = () => {
                const value = getCookie(SIDEBAR_KEY);
                // Default to "true" (open) if no cookie exists
                return value !== null ? value : "true";
            };

            const applyTheme = (theme) => {
                document.documentElement.setAttribute("data-theme", theme);
                document.documentElement.style.backgroundColor =
                    theme === "dark" ? "#1d232a" : "#f3f4f6";
            };

            // Apply theme immediately
            applyTheme(getTheme());

            // Store sidebar state globally so we can access it when rendering
            window.__sidebarState = getSidebarDrawer() === "true";
        })();
    </script>
</head>

<body class="bg-base-100" data-portal="admin">
    <div class="min-h-screen flex bg-base-100">
        <!-- Sidebar -->
        <div class="drawer drawer-open">
            <!-- Checkbox toggle for the drawer -->
            <input id="sidebar-drawer" type="checkbox" class="drawer-toggle" />
            <script>
                (function() {
                    const checkbox = document.getElementById('sidebar-drawer');
                    if (checkbox && typeof window.__sidebarState !== 'undefined') {
                        checkbox.checked = window.__sidebarState;
                    }
                })();
            </script>

            <!-- Main content area -->
            <div class="drawer-content flex flex-col min-h-screen bg-base-100">
                <div class="dock dock-md">
                    <a href="{{ route('admin.users.index') }}" class="dock-active">
                        <svg class="size-[1.2em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g fill="currentColor" stroke-linejoin="miter" stroke-linecap="butt">
                                <polyline points="1 11 12 2 23 11" fill="none" stroke="currentColor"
                                    stroke-miterlimit="10" stroke-width="2"></polyline>
                                <path d="m5,13v7c0,1.105.895,2,2,2h10c1.105,0,2-.895,2-2v-7" fill="none"
                                    stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10"
                                    stroke-width="2"></path>
                                <line x1="12" y1="22" x2="12" y2="18" fill="none"
                                    stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10"
                                    stroke-width="2"></line>
                            </g>
                        </svg>
                        <span class="dock-label">Home</span>
                    </a>

                    <a>
                        <svg class="size-[1.2em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g fill="currentColor" stroke-linejoin="miter" stroke-linecap="butt">
                                <polyline points="3 14 9 14 9 17 15 17 15 14 21 14" fill="none" stroke="currentColor"
                                    stroke-miterlimit="10" stroke-width="2"></polyline>
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"
                                    fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10"
                                    stroke-width="2"></rect>
                            </g>
                        </svg>
                        <span class="dock-label">Inbox</span>
                    </a>

                    <button>
                        <svg class="size-[1.2em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g fill="currentColor" stroke-linejoin="miter" stroke-linecap="butt">
                                <circle cx="12" cy="12" r="3" fill="none" stroke="currentColor"
                                    stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></circle>
                                <path
                                    d="m22,13.25v-2.5l-2.318-.966c-.167-.581-.395-1.135-.682-1.654l.954-2.318-1.768-1.768-2.318.954c-.518-.287-1.073-.515-1.654-.682l-.966-2.318h-2.5l-.966,2.318c-.581.167-1.135.395-1.654.682l-2.318-.954-1.768,1.768.954,2.318c-.287.518-.515,1.073-.682,1.654l-2.318.966v2.5l2.318.966c.167.581.395,1.135.682,1.654l-.954,2.318,1.768,1.768,2.318-.954c.518.287,1.073.515,1.654.682l.966,2.318h2.5l.966-2.318c.581-.167,1.135-.395,1.654-.682l2.318.954,1.768-1.768-.954-2.318c.287-.518.515-1.073.682-1.654l2.318-.966Z"
                                    fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10"
                                    stroke-width="2"></path>
                            </g>
                        </svg>
                        <span class="dock-label">Settings</span>
                    </button>
                </div>
                {{ $slot }}
            </div>
        </div>
    </div>

    <!-- Event listener for saving state (at the end of body) -->
    <script>
        (function() {
            const sidebarToggle = document.getElementById("sidebar-drawer");
            if (sidebarToggle) {
                sidebarToggle.addEventListener("change", function() {
                    // Set cookie with 1 year expiry to persist the state
                    const expires = new Date();
                    expires.setFullYear(expires.getFullYear() + 1);
                    document.cookie =
                        `sidebar-drawer=${sidebarToggle.checked}; path=/; expires=${expires.toUTCString()}`;
                });
            }
        })();
    </script>
</body>

</html>
