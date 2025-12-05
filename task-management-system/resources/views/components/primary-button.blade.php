<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary rounded-full']) }}>
    {{ $slot }}
</button>
