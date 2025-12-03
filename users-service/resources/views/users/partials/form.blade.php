<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @method($method)


    @include('shared.input', [
        'field' => 'name',
        'label' => 'Name',
        'type' => 'text',
        'value' => old('name', $user->name),
        'placeholder' => 'Enter last name',
        'required' => true,
    ])

    @include('shared.input', [
        'field' => 'email',
        'label' => 'Email Address',
        'type' => 'email',
        'value' => old('email', $user->email),
        'placeholder' => 'Enter email address',
        'required' => true,
    ])

    @include('shared.input', [
        'field' => 'password',
        'label' => 'New Password',
        'type' => 'password',
        'value' => '',
        'placeholder' => 'Enter new password',
        'help' => '(Leave blank to keep current password)',
        'required' => $method === 'POST',
    ])

    @include('shared.input', [
        'field' => 'password_confirmation',
        'label' => 'Confirm New Password',
        'type' => 'password',
        'value' => '',
        'placeholder' => 'Confirm new password',
        'required' => $method === 'POST',
    ])


    @include('shared.action', [
        'cancelRoute' => route('users.index'),
        'model' => 'User',
        'showCancelButton' => false,
    ])

</form>
