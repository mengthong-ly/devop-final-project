<x-admin-layout :crumps="[
    // ['label' => 'Dashboard', 'url' => route('dashboard.index')],
    ['label' => 'Users', 'url' => route('users.index')],
]">
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    @include('shared.alert')

    <div class="min-h-screen min-w-screen">
        <div class="sm:rounded-lg px-5">
            {{-- title --}}
            <div class=" flex justify-between items-center">
                <p class="text-3xl font-semibold text-content pt-4">Users</p>
            </div>
            {{-- search and action --}}
            <div class="flex flex-row pt-4 justify-between">
                @include('users.partials.filter')
                <div class="mb-4 pt-4">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary rounded-full">Create User</a>
                </div>
            </div>

            {{-- table --}}
            @include('users.partials.table', ['users' => $users])
        </div>
    </div>

</x-admin-layout>
