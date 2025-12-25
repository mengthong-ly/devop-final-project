<x-admin-layout :crumps="[['label' => 'Users', 'url' => route('admin.users.index')]]">
    @include('shared.alert')

    <div class="w-full">
        {{-- title --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-base-content">Users</h1>
        </div>

        {{-- search and action --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center mb-6">
            @include('users.partials.filter')
            <div>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Create User</a>
            </div>
        </div>

        {{-- table --}}
        @include('users.partials.table', ['users' => $users])
    </div>

</x-admin-layout>
