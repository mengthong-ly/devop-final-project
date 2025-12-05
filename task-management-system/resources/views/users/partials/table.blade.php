<div class="overflow-x-auto">
    <div class="rounded-lg border border-base-content/5 bg-base-100 shadow-sm">
        <table class="table w-full">
            <thead class="bg-base-200">
                <tr>
                    <th class="text-left">#</th>
                    <th class="text-left">Name</th>
                    <th class="text-left">Email</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $user)
                    <tr class="hover:bg-base-200/50">
                        <th class="font-normal">{{ $loop->iteration }}</th>
                        <td>
                            <a href="{{ route('admin.users.edit', $user) }}"
                                class="link link-primary link-hover font-medium">
                                {{ Str::ucfirst($user->name) }}
                            </a>
                        </td>
                        <td class="text-base-content/70">{{ $user->email }}</td>
                        <td class="text-center">@include('users.partials.actions')</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-8 text-base-content/60">
                            No users found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
