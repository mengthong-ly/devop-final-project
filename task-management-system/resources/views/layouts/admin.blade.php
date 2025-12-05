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
        <div class="drawer lg:drawer-open">
            <input id="my-drawer-4" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content">
                <!-- Navbar -->
                <nav class="navbar w-full bg-base-300 flex flex-row justify-between">
                    <div class="flex justify-between w-full">
                        <div class="flex items-center">
                            <label for="my-drawer-4" aria-label="open sidebar" class="btn btn-square btn-ghost">
                                <!-- Sidebar toggle icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-linejoin="round"
                                    stroke-linecap="round" stroke-width="2" fill="none" stroke="currentColor"
                                    class="my-1.5 inline-block size-4">
                                    <path
                                        d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z">
                                    </path>
                                    <path d="M9 4v16"></path>
                                    <path d="M14 10l2 2l-2 2"></path>
                                </svg>
                            </label>
                            <div class="px-4">Task Management</div>
                        </div>
                        <div>
                            <div class="dropdown dropdown-bottom dropdown-end">
                                <div tabindex="0" role="button" class="btn btn-circle m-1">
                                    <x-heroicon-o-bell class="w-4 h-4"> </x-heroicon-o-bell>
                                </div>
                                <div
                                    class="dropdown-content bg-base-100 rounded-box z-1 w-80 shadow-lg border border-base-content/10 max-h-64 overflow-y-auto">
                                    @forelse ($notifications as $notification)
                                        <div class="notification-item p-3 hover:bg-base-200 border-b border-base-content/5 {{ $notification->is_read ? 'opacity-75' : 'bg-info/5 border-l-2 border-l-primary' }}"
                                            data-notification-id="{{ $notification->id }}">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h4 class="font-semibold text-sm">
                                                        {{ $notification->title ?? 'Notification' }}</h4>
                                                    <p class="text-xs text-base-content/70 mt-1">
                                                        {{ $notification->message ?? 'No message' }}</p>
                                                    <span
                                                        class="text-xs text-base-content/50 mt-1">{{ $notification->created_at?->diffForHumans() }}</span>
                                                </div>
                                                @if (!$notification->is_read)
                                                    <span class="badge badge-xs badge-primary ml-2"></span>
                                                @endif
                                            </div>

                                            <div class="flex gap-2 mt-2">
                                                @if (isset($notification->data['task_id']))
                                                    <a href="{{ route('admin.tasks.show', $notification->data['task_id']) }}"
                                                        class="btn btn-xs btn-outline">View Task</a>
                                                @endif
                                                @if (isset($notification->data['user_id']))
                                                    <a href="{{ route('admin.users.show', $notification->data['user_id']) }}"
                                                        class="btn btn-xs btn-outline">View User</a>
                                                @endif
                                                @if (!$notification->is_read)
                                                    <button onclick="markAsRead('{{ $notification->id }}')"
                                                        class="btn btn-xs btn-ghost">Mark Read</button>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div class="p-8 text-center text-base-content/60">
                                            <x-heroicon-o-bell-slash
                                                class="w-8 h-8 mx-auto mb-2 text-base-content/30" />
                                            <p>No notifications</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
                <!-- Page content here -->
                <main class="flex-1 p-6 bg-base-100">
                    {{ $slot }}
                </main>
            </div>

            <div class="drawer-side is-drawer-close:overflow-visible ">
                <label for="my-drawer-4" aria-label="close sidebar" class="drawer-overlay"></label>
                <div class="flex min-h-full flex-col items-start bg-base-200 is-drawer-close:w-14 is-drawer-open:w-64">
                    <!-- Sidebar content here -->
                    <ul class="menu w-full grow">
                        <!-- List item -->
                        <li>
                            <a class="is-drawer-close:tooltip is-drawer-close:tooltip-right" data-tip="Users"
                                href="{{ route('admin.users.index') }}">
                                <!-- Home icon -->
                                <x-heroicon-o-user class="w-4 h-4" />
                                <span class="is-drawer-close:hidden">Users</span>
                            </a>
                        </li>

                        <!-- List item -->
                        <li>
                            <a class="is-drawer-close:tooltip is-drawer-close:tooltip-right" data-tip="Task"
                                href="{{ route('admin.tasks.index') }}">
                                <!-- Settings icon -->
                                <x-heroicon-o-rectangle-stack class="w-4 h-4" />
                                <span class="is-drawer-close:hidden">Tasks</span>
                            </a>
                        </li>
                        <div class="divider"></div>
                        <!-- List item -->
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                @method('POST')
                                <button type="submit" class="is-drawer-close:tooltip is-drawer-close:tooltip-right"
                                    data-tip="Logout">
                                    <!-- Logout icon -->
                                    <x-heroicon-o-arrow-right-start-on-rectangle class="w-4 h-4" />
                                    <span class="is-drawer-close:hidden">Logout</span>
                                </button>
                            </form>
                        </li>

                    </ul>
                </div>
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

        // Mark notification as read
        function markAsRead(notificationId) {
            fetch(`/admin/notifications/${notificationId}/mark-read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the notification item visually
                        const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
                        if (notificationItem) {
                            notificationItem.classList.remove('bg-info/5', 'border-l-2', 'border-l-primary');
                            notificationItem.classList.add('opacity-75');

                            // Remove the unread badge
                            const badge = notificationItem.querySelector('.badge-primary');
                            if (badge) badge.remove();

                            // Remove the mark read button
                            const markReadBtn = notificationItem.querySelector('button[onclick*="markAsRead"]');
                            if (markReadBtn) markReadBtn.remove();
                        }
                    }
                })
                .catch(error => console.error('Error marking notification as read:', error));
        }
    </script>
</body>

</html>
