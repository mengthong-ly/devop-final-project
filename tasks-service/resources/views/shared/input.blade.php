<div class="form-control w-full">
    <label class="label" for="{{ $field }}">
        <p class = "label-text text-sm">{{ $label }}</p>
    </label>
    <div class = 'input w-full p-0 input-lg'>
        <input type="{{ $type }}" id="{{ $field }}" name="{{ $field }}" value="{{ $value }}"
            placeholder="{{ $placeholder }}" @if ($disabled ?? false) disabled @endif
            class="input input-lg text-base w-full @error('{{ $field }}') input-error @enderror"
            @if ($required ?? false) required @endif />
    </div>
    @error('{{ $field }}')
        <label class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
    @enderror
</div>
