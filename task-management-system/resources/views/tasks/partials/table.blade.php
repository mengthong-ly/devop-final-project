<div class="overflow-x-auto">
    <div class="rounded-lg border border-base-content/5 bg-base-100 shadow-sm">
        <table class="table w-full">
            <thead class="bg-base-200">
                <tr>
                    <th class="text-left">#</th>
                    <th class="text-left">Title</th>
                    <th class="text-left">Description</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tasks as $index => $task)
                    <tr class="hover:bg-base-200/50">
                        <th class="font-normal">{{ $loop->iteration }}</th>
                        <td>
                            <a href="{{ route('admin.tasks.edit', $task) }}"
                                class="link link-primary link-hover font-medium">
                                {{ Str::ucfirst($task->title) }}
                            </a>
                        </td>
                        <td class="text-base-content/70">{{ Str::limit($task->description, 50) }}</td>
                        <td class="text-center">@include('tasks.partials.actions')</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-8 text-base-content/60">
                            No tasks found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
