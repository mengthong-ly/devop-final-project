<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @method($method)


    @include('shared.input', [
        'field' => 'title',
        'label' => 'Title',
        'type' => 'text',
        'value' => old('title', $task->title),
        'placeholder' => 'Enter Title',
        'required' => true,
    ])

    @include('shared.input', [
        'field' => 'description',
        'label' => 'Description',
        'type' => 'text',
        'value' => old('description', $task->description),
        'placeholder' => 'Enter Description',
        'required' => true,
    ])


    @include('shared.action', [
        'cancelRoute' => route('admin.tasks.index'),
        'model' => 'Task',
        'showCancelButton' => false,
    ])

</form>
