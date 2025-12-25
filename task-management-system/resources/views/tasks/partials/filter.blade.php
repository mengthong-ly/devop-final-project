<div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
    @include('shared.search', [
        'route' => route('admin.tasks.index'),
        'placeholder' => 'Search tasks...',
    ])
</div>
