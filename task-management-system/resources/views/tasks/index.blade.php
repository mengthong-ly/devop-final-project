<x-admin-layout :crumps="[['label' => 'Tasks', 'url' => route('admin.tasks.index')]]">
    @include('shared.alert')

    <div class="w-full">
        {{-- title --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-base-content">Tasks</h1>
        </div>

        {{-- search and action --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center mb-6">
            @include('tasks.partials.filter')
            <div>
                <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">Create Task</a>
            </div>
        </div>

        {{-- table --}}
        @include('tasks.partials.table', ['tasks' => $tasks])
    </div>

</x-admin-layout>
