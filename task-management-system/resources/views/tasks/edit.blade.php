@php
    $model = 'tasks';
    $title = 'tasks';

    $tablinks = [
        [
            'label' => 'Detail',
            'url' => route('admin.' . $model . '.edit', $task),
            'icon' => 'heroicon-o-document-text',
        ],
    ];
@endphp

<x-admin-layout :crumps="[
    ['label' => $title, 'url' => route('admin.' . $model . '.index')],
    ['label' => 'Edit', 'url' => route('admin.' . $model . '.edit', $task)],
]">

    <!-- Page Container -->
    <div class="p-6">

        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('admin.tasks.index') }}" class="btn btn-sm rounded-full btn-ghost gap-2 hover:btn-primary">
                <x-heroicon-o-arrow-left class="w-4 h-4" />
                Back to tasks
            </a>
        </div>

        {{-- Alerts --}}
        @include('shared.alert')

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

            <!-- LEFT — TASK FORM (3/4) -->
            <div class="lg:col-span-3 space-y-6">

                <div class="card bg-base-200 shadow-lg p-6">
                    <h3 class="text-xl font-semibold mb-4">Task Details</h3>

                    @include('tasks.partials.form', [
                        'action' => route('admin.tasks.update', $task),
                        'method' => 'PATCH',
                        'model' => 'Task',
                        'cancelRoute' => route('admin.tasks.index'),
                    ])
                </div>

            </div>

            <!-- RIGHT — ASSIGNED USERS (1/4) -->
            <div class="lg:col-span-1">

                <div class="card bg-base-200 shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Assigned Users</h3>

                        <!-- ASSIGN USER BUTTON -->
                        <button onclick="assignUserModal.showModal()" class="btn btn-sm btn-primary gap-2">
                            <x-heroicon-o-plus class="w-4 h-4" /> Assign
                        </button>
                    </div>

                    @if (count($task->users ?? []) > 0)
                        <div class="space-y-3">
                            @foreach ($task->users as $user)
                                <div class="p-3 bg-base-100 rounded-lg shadow-sm flex justify-between items-center">
                                    <div>
                                        <span class="font-bold">{{ $user->name }}</span>
                                        <span class="block text-sm text-base-content/60">{{ $user->email }}</span>
                                    </div>

                                    <form action="{{ route('admin.tasks.unassign', $task->id) }}" method="POST"
                                        onsubmit="return confirm('Remove this user?')">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <button class="btn btn-xs btn-error">Remove</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-base-content/60">No users assigned.</p>
                    @endif
                </div>

            </div>

        </div>

    </div>

    <!-- ASSIGN USER MODAL -->
    <dialog id="assignUserModal" class="modal">
        <div class="modal-box max-w-md">
            <h3 class="font-bold text-lg mb-3">Assign Users</h3>

            <form method="POST" action="{{ route('admin.tasks.assign', $task->id) }}">
                @csrf

                <div class="space-y-3 max-h-64 overflow-y-auto">
                    @php
                        $assignedUserIds = collect($task->users)->pluck('id')->toArray();
                    @endphp

                    @foreach ($task->all_users as $user)
                        @if (!in_array($user->id, $assignedUserIds))
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="user_ids[]" value="{{ $user->id }}"
                                    class="checkbox checkbox-sm" />

                                <span>{{ $user->name }} ({{ $user->email }})</span>
                            </label>
                        @endif
                    @endforeach

                    @if (count($task->all_users) === count($assignedUserIds))
                        <p class="text-sm text-base-content/60">All users are already assigned to this task.</p>
                    @endif

                </div>

                <div class="modal-action">
                    <button type="submit" class="btn btn-primary">Assign</button>
                    <button type="button" onclick="assignUserModal.close()" class="btn">Cancel</button>
                </div>
            </form>
        </div>
    </dialog>

</x-admin-layout>
