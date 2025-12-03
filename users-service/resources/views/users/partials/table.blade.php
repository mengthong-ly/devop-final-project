<div class="rounded-box border border-base-content/5 bg-base-100">
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $index => $user)
                <tr>
                    <th class="font-normal">{{ $loop->iteration }}.</th>
                    <td><a href="{{ route('admin.users.edit', $user) }}" class="link link-primary link-hover">
                            {{ Str::ucfirst($user->name) }}
                        </a></td>
                    <td>{{ $user->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
