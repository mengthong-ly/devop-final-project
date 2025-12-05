<div class="dropdown dropdown-end">
    <div tabindex="0" role="button" class="btn btn-ghost btn-sm btn-square">
        <x-heroicon-o-ellipsis-vertical class="w-4 h-4" />
    </div>
    <ul tabindex="0"
        class="dropdown-content menu bg-base-100 rounded-box z-10 p-2 w-48 shadow-lg border border-base-content/10">
        <li>
            <a href="{{ route('admin.tasks.edit', $task) }}" class="gap-2">
                <x-heroicon-o-pencil class="w-4 h-4" />
                Edit Task
            </a>
        </li>
        <li>
            <form method="POST" action="{{ route('admin.tasks.destroy', $task) }}" class="w-full"
                onsubmit="return confirm('Are you sure you want to delete this task?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="flex w-full gap-2 text-error hover:bg-error hover:text-error-content">
                    <x-heroicon-o-trash class="w-4 h-4" />
                    Delete Task
                </button>
            </form>
        </li>
    </ul>
</div>
