@php
    $model = 'tasks';
    $title = 'tasks';
@endphp

<x-admin-layout :crumps="[
    ['label' => 'tasks', 'url' => route('admin.tasks.index')],
    ['label' => 'Create', 'url' => route('admin.tasks.create', $task)],
]">
    <div class="p-6">
        <!-- Back Button at top level -->
        <div class="mb-4">
            <a href="{{ route('' . $model . '.index') }}"
                class="btn btn-sm rounded-full btn-ghost gap-2 hover:btn-primary">
                <x-heroicon-o-arrow-left class="w-4 h-4" />
                Back to Option Types
            </a>
        </div>

        <div class="bg-base-100 sm:rounded-lg shadow-lg">
            <div class="p-6">
                <!-- Header Section -->
                <div class="flex items-center mb-6 gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-base-content">Create tasks</h2>
                        <p class="text-sm text-base-content/60 mt-1">
                            Define a new option type to enhance product customization
                        </p>
                    </div>
                </div>
                {{-- alert --}}
                @include('shared.alert')

                {{-- form --}}
                @include('tasks.partials.form', [
                    'action' => route('admin.tasks.store'),
                    'method' => 'POST',
                    'model' => 'task',
                    'cancelRoute' => route('admin.tasks.index'),
                ])
            </div>
        </div>
    </div>
</x-admin-layout>
