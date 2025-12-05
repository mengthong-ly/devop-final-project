@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-md bg-base-100 h-12 border p-3']) }}>
