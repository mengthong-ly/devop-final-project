@php
    $model = 'users';
    $title = 'Users';

    $tablinks = [
        [
            'label' => 'Detail',
            'url' => route('admin.' . $model . '.edit', $user),
            'icon' => 'heroicon-o-document-text',
        ],
    ];

    // Add supplier tab if user has a supplier
    if ($user->supplier) {
        $tablinks[] = [
            'label' => 'Supplier',
            'url' => route('users.suppliers.edit', [$user, $user->supplier]),
            'icon' => 'heroicon-o-building-storefront',
        ];
    }
@endphp

<x-admin-layout :crumps="[
    ['label' => $title, 'url' => route('admin.' . $model . '.index')],
    ['label' => 'Edit', 'url' => route('admin.' . $model . '.edit', $user)],
]">
    <div class="p-6">
        <!-- Back Button at top level -->
        <div class="mb-4">
            <a href="{{ route('admin.' . $model . '.index') }}"
                class="btn btn-sm rounded-full btn-ghost gap-2 hover:btn-primary">
                <x-heroicon-o-arrow-left class="w-4 h-4" />
                Back to Users
            </a>
        </div>

        <div class="bg-base-100 sm:rounded-lg shadow-lg">
            <div class="p-6">
                <!-- Header Section -->
                <div class="flex items-center mb-6 gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-base-content">Edit User</h2>
                        <p class="text-sm text-base-content/60 mt-1">
                            Modify "{{ $user->first_name }}" user profile and settings
                        </p>
                    </div>
                </div>

                {{-- alert --}}
                @include('shared.alert')

                <!-- Tab Navigation -->
                @include('users.partials.tabs', ['tabs' => $tablinks])

                <!-- Usage Statistics -->
                <div class="stats shadow mt-6 mb-6">
                    <div class="stat">
                        <div class="stat-figure text-primary">
                            <x-heroicon-o-user class="w-8 h-8" />
                        </div>
                        <div class="stat-title">User Type</div>
                        <div class="stat-value text-primary">{{ ucfirst($user->role ?? 'User') }}</div>
                        <div class="stat-desc">Account role</div>
                    </div>

                    <div class="stat">
                        <div class="stat-figure text-secondary">
                            <x-heroicon-o-envelope class="w-8 h-8" />
                        </div>
                        <div class="stat-title">Email Status</div>
                        <div class="stat-value text-secondary">{{ $user->email_verified_at ? 'Verified' : 'Pending' }}
                        </div>
                        <div class="stat-desc">Email verification</div>
                    </div>

                    <div class="stat">
                        <div class="stat-figure text-accent">
                            <x-heroicon-o-calendar class="w-8 h-8" />
                        </div>
                        <div class="stat-title">Last Updated</div>
                        <div class="stat-value text-accent text-sm">
                            {{ $user->updated_at->diffForHumans() }}</div>
                        <div class="stat-desc">{{ $user->updated_at->format('M d, Y') }}</div>
                    </div>
                </div>

                <!-- Detail Tab -->
                <div class="space-y-6">
                    <!-- Form Card -->
                    <div class="mt-4">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="badge badge-primary">Required</div>
                            <h3 class="text-lg font-semibold">Basic Information</h3>
                        </div>

                        @include('users.partials.form', [
                            'action' => route('users.update', $user),
                            'method' => 'PATCH',
                            'model' => 'User',
                            'cancelRoute' => route('users.index'),
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
