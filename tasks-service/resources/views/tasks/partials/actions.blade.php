<div class="flex flex-row justify-start gap-2">
    @include('users.partials.approval', ['user' => $user])
    <div class="dropdown dropdown-end">
        <div tabindex="0" role="button" class="btn btn-circle"> <x-heroicon-o-ellipsis-vertical class="w-5 h-5" />
        </div>
        <ul tabindex="-1"
            class="dropdown-content menu bg-base-100 rounded-box z-1 p-2 w-48 shadow-xl border border-base-content/10">
            <li><a href="{{ route('users.edit', $user) }}" class=""><x-heroicon-o-pencil class="w-4 h-4" />Edit
                    User</a></li>
            <li class="m-0 p-0 w-full">
                <form method="POST" action="{{ route('users.destroy', $user) }}" class="m-0 p-0 w-full block"
                    onsubmit="return confirm('Are you sure you want to delete this user?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="flex bg-error flex-row gap-2 px-3 py-1 hover:bg-gray-300 rounded w-full"
                        id="delete-user-{{ $user->id }}">
                        <x-heroicon-o-trash class="w-4 h-4 text-white" />
                        <span class="text-white">Delete User</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>
