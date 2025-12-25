<div class="form-control w-full">
    <label class="label" for="{{ $field }}">
        <p class="label-text text-sm">{{ $label }}</p>
    </label>
    <div class="select select-lg w-full">
        <select id="{{ $field }}" name="{{ $field }}"
            class="select select-lg w-full @error('{{ $field }}') select-error @enderror"
            @if ($disabled ?? false) disabled @endif @if ($required ?? false) required @endif>

            @if ($placeholder ?? false)
                <option value="" disabled @if (empty($value)) selected @endif>{{ $placeholder }}
                </option>
            @endif

            @foreach ($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" @if (old($field, $value) == $optionValue) selected @endif>
                    {{ $optionLabel }}
                </option>
            @endforeach
        </select>
    </div>
    @error('{{ $field }}')
        <label class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
    @enderror
</div>
