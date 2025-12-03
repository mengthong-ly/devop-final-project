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

@php
    $sidebarLinks = [
        [
            'label' => 'Dashboard',
            'route' => 'supplier.dashboard.index',
            'icon' => 'heroicon-o-building-storefront',
            'header' => 'supplier.dashboard',
        ],
        [
            'label' => 'Products',
            'route' => 'supplier.products.index',
            'icon' => 'heroicon-o-shopping-bag',
            'header' => 'supplier.products',
        ],
        [
            'label' => 'Orders',
            'route' => 'supplier.orders.index',
            'icon' => 'heroicon-o-shopping-bag',
            'header' => 'supplier.orders',
        ],
        // [
        //     'label' => 'LineItem',
        //     'route' => 'supplier.line-items.index',
        //     'icon' => 'heroicon-o-inbox-stack',
        //     'header' => 'supplier.line-items',
        // ],
        // [
        //     'label' => 'Users',
        //     'route' => 'supplier.users.index',
        //     'icon' => 'heroicon-o-user-circle',
        //     'header' => 'supplier.users',
        // ],

        // [
        //     'label' => 'Category',
        //     'route' => 'supplier.categories.index',
        //     'icon' => 'heroicon-o-tag',
        //     'header' => 'supplier.categories',
        // ],
        // [
        //     'label' => 'Products',
        //     'route' => 'supplier.products.index',
        //     'icon' => 'heroicon-o-cube',
        //     'header' => 'supplier.products',
        // ],
        [
            'label' => 'OptionTypes',
            'route' => 'supplier.option-types.index',
            'icon' => 'heroicon-o-rectangle-group',
            'header' => 'supplier.option-types',
        ],
        // [
        //     'label' => 'OptionValues',
        //     'route' => 'supplier.option-values.index',
        //     'icon' => 'heroicon-o-rectangle-stack',
        //     'header' => 'supplier.option-values',
        // ],
        // [
        //     'label' => 'Roles',
        //     'route' => 'supplier.roles.index',
        //     'icon' => 'heroicon-o-shield-exclamation',
        //     'header' => 'supplier.roles',
        // ],
        // [
        //     'label' => 'Permissions',
        //     'route' => 'supplier.permissions.index',
        //     'icon' => 'heroicon-o-exclamation-circle',
        //     'header' => 'supplier.permissions',
        // ],
        // [
        //     'label' => 'Sections',
        //     'route' => 'supplier.home-section.index',
        //     'icon' => 'heroicon-o-exclamation-circle',
        //     'header' => 'supplier.home-section',
        // ],
        // [
        //     'label' => 'Reports Blueprints',
        //     'route' => 'supplier.report-blueprints.index',
        //     'icon' => 'heroicon-o-book-open',
        //     'header' => 'supplier.report-blueprints',
        // ],
        [
            'label' => 'Reports',
            'route' => 'supplier.reports.index',
            'icon' => 'heroicon-o-book-open',
            'header' => 'supplier.reports',
        ],
        [
            'label' => 'Settings',
            'route' => 'supplier.settings.index',
            'icon' => 'heroicon-o-cog-6-tooth',
            'header' => 'supplier.settings',
        ],
    ];
@endphp

<body class="bg-base-100" data-portal="supplier">
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
                @if (isset($crumps) && count($crumps) > 0)
                    <x-navigation :crumps="$crumps" />
                @endif
                {{ $slot }}
            </div>

            <!-- Sidebar -->
            <div class="drawer-side is-drawer-close:overflow-visible bg-base-100 z-0">
                <!-- Overlay (for mobile screens) -->
                <label for="sidebar-drawer" class="drawer-overlay"></label>

                <aside
                    class="is-drawer-close:w-16 is-drawer-open:w-64 bg-base-200 min-h-screen flex flex-col shadow-md transition-all duration-300">
                    <div class="flex flex-col flex-1">
                        <!-- Header / Logo -->
                        <div class="mt-5 ml-4 mb-4 flex items-center gap-2">
                            <a class="text-xl font-bold is-drawer-close:hidden">Phsar Khmer</a>
                            <a class="btn btn-ghost btn-circle is-drawer-open:hidden">
                                🛒
                            </a>
                        </div>

                        <!-- Menu Section -->
                        <ul class="menu w-full">
                            <li class="menu-title is-drawer-close:hidden">MENU</li>
                            @foreach ($sidebarLinks as $sidebarLink)
                                <li>
                                    <a href="{{ route($sidebarLink['route']) }}"
                                        class="is-drawer-close:tooltip is-drawer-close:tooltip-right {{ request()->routeIs($sidebarLink['header'] . '*') ? 'active bg-primary text-primary-content' : '' }}"
                                        data-tip="{{ $sidebarLink['label'] }}">
                                        <x-dynamic-component :component="$sidebarLink['icon']"
                                            class="w-4 h-4 inline-block size-4 my-1.5 is-drawer-close:mx-auto" />
                                        <span class="is-drawer-close:hidden">{{ $sidebarLink['label'] }}</span>
                                    </a>
                                </li>
                            @endforeach

                            <li class="menu-title is-drawer-close:hidden">GENERAL</li>
                            <li>
                                <a href="#"
                                    class="{{ request()->routeIs('supplier.logout*') ? 'active bg-primary text-primary-content' : '' }}">
                                    <span class="is-drawer-close:hidden">Logout</span>
                                    <span
                                        class="is-drawer-open:hidden is-drawer-close:tooltip is-drawer-close:tooltip-right"
                                        data-tip="Logout">
                                        <i class="icon"></i>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- Footer / Drawer Toggle (always at bottom) -->
                    <div class="m-2 is-drawer-close:tooltip is-drawer-close:tooltip-right" data-tip="Open Drawer">
                        <label for="sidebar-drawer"
                            class="btn btn-ghost btn-circle drawer-button is-drawer-open:rotate-y-180 transition-transform duration-300">
                            <x-heroicon-o-arrow-right-start-on-rectangle class="w-4 h-4" />
                        </label>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</body>

<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqswOGusjvSomrepB0xIuYt1W0JOs1bZs&libraries=places&callback=initAutocomplete"
    async defer></script>

<script>
    let map, marker, autocomplete, geocoder;

    function initAutocomplete() {
        const input = document.getElementById("autocomplete");
        const latInput = document.getElementById("latitude");
        const lngInput = document.getElementById("longitude");

        // Initialize geocoder
        geocoder = new google.maps.Geocoder();

        const savedLat = parseFloat(document.getElementById("latitude").value);
        const savedLng = parseFloat(document.getElementById("longitude").value);

        const defaultLocation = (!isNaN(savedLat) && !isNaN(savedLng)) ? {
            lat: savedLat,
            lng: savedLng
        } : {
            lat: 11.5564,
            lng: 104.9282
        }; // Phnom Penh default


        // Initialize map
        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultLocation,
            zoom: 13,
        });

        // Initialize marker
        marker = new google.maps.Marker({
            position: defaultLocation,
            map: map,
            draggable: false,
        });

        // Initialize autocomplete
        autocomplete = new google.maps.places.Autocomplete(input, {
            fields: ["geometry", "formatted_address"],
            types: ["geocode"],
        });

        // When user selects an address
        autocomplete.addListener("place_changed", function() {
            const place = autocomplete.getPlace();
            if (!place.geometry || !place.geometry.location) return;

            const lat = place.geometry.location.lat();
            const lng = place.geometry.location.lng();

            updateMapAndInputs(lat, lng, place.formatted_address);
        });

        // 🧭 When user clicks anywhere on the map
        google.maps.event.addListener(map, "click", function(event) {
            const lat = event.latLng.lat();
            const lng = event.latLng.lng();

            // Move marker
            marker.setPosition(event.latLng);

            // Update lat/lng inputs
            latInput.value = lat;
            lngInput.value = lng;

            // Reverse geocode to get address
            geocoder.geocode({
                location: event.latLng
            }, function(results, status) {
                if (status === "OK" && results[0]) {
                    const address = results[0].formatted_address;
                    input.value = address; // show it in the address field
                    console.log("📍 Clicked Address:", address);
                } else {
                    console.warn("Geocoder failed due to: " + status);
                }
            });
        });
    }

    // Helper to center map, move marker, and fill inputs
    function updateMapAndInputs(lat, lng, address) {
        const latInput = document.getElementById("latitude");
        const lngInput = document.getElementById("longitude");
        const input = document.getElementById("autocomplete");

        latInput.value = lat;
        lngInput.value = lng;
        input.value = address;

        map.setCenter({
            lat,
            lng
        });
        map.setZoom(16);
        marker.setPosition({
            lat,
            lng
        });
    }

    window.initAutocomplete = initAutocomplete;
</script>
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

</html>
