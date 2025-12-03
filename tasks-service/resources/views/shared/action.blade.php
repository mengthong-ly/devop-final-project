@if ($showCancelButton ?? true)
    <div class="flex justify-end gap-4 pt-6">
        <a href="{{ $cancelRoute }}" class="btn btn-outline rounded-full">
            Cancel
        </a>
        <button type="submit" class="btn btn-primary rounded-full">
            @if (request()->routeIs('*.create'))
                Create {{ $model }}
            @else
                Update {{ $model }}
            @endif
        </button>
    </div>
@else
    <div class="flex justify-end pt-6">
        <button type="submit" class="btn btn-primary rounded-full">
            @if (request()->routeIs('*.create'))
                Create {{ $model }}
            @else
                Update {{ $model }}
            @endif
        </button>
    </div>
@endif
