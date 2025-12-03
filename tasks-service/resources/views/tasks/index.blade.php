<x-admin-layout :crumps="[
    // ['label' => 'Dashboard', 'url' => route('dashboard.index')],
    ['label' => 'tasks', 'url' => route('admin.tasks.index')],
]">
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Task') }}
        </h2>
    </x-slot>

    @include('shared.alert')

    <div class="min-h-screen min-w-screen">
        <div class="sm:rounded-lg px-5">
            {{-- title --}}
            <div class=" flex justify-between items-center">
                <p class="text-3xl font-semibold text-content pt-4">tasks</p>
            </div>
            {{-- search and action --}}
            <div class="flex flex-row pt-4 justify-between">
                {{-- @include('tasks.partials.filter') --}}
                hi
                <div class="mb-4 pt-4">
                    <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary rounded-full">Create Task</a>
                </div>
            </div>

            {{-- table --}}
            @include('tasks.partials.table', ['tasks' => $tasks])
        </div>
    </div>

</x-admin-layout>
