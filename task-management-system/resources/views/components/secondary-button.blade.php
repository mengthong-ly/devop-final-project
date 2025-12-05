<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-secondary rounded-full']) }}>
    {{ $slot }}
</button>
