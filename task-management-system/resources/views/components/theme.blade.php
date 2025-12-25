@php
    $themes = ['light', 'dark'];
@endphp

<div class="dropdown dropdown-hover dropdown-end" data-controller="theme">
    <div tabindex="0" role="button" class="btn h-11 text-xs sm:text-base rounded-full">
        Theme
        <svg class="size-3 inline-block ms-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M3.5 6.5L8 10l4.5-3.5" />
        </svg>
    </div>

    <div tabindex="0"
        class="p-2 overflow-hidden shadow-2xl w-52 z-10 dropdown-content bg-base-100 rounded-box outline-1 outline-base-content/10">
        <ul class="overflow-y-auto flex flex-col gap-2 p-1">
            @foreach ($themes as $theme)
                <li>
                    <button type="button" class="justify-start btn btn-sm btn-block rounded-full text-sm"
                        aria-label="{{ ucfirst($theme) }}" data-action="click->theme#select"
                        data-theme="{{ $theme }}">
                        {{ ucfirst($theme) }}
                    </button>
                </li>
            @endforeach
        </ul>
    </div>
</div>
