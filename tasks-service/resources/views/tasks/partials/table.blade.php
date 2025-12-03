<div class="rounded-box border border-base-content/5 bg-base-100">
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>Title</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $index => $task)
                <tr>
                    <th class="font-normal">{{ $loop->iteration }}.</th>
                    <td><a href="{{ route('admin.tasks.edit', $task) }}" class="link link-primary link-hover">
                            {{ Str::ucfirst($task->title) }}
                        </a></td>
                    <td>{{ $task->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
