@php
    use Illuminate\Support\Str;
@endphp
<div role="tablist" class="tabs tabs-border text-primary w-full border-b mb-6">
    @foreach ($tablinks as $tab)
        <a role="tab" href="{{ $tab['url'] }}"
            class="tab gap-2 {{ Str::startsWith(request()->fullUrl(), $tab['url']) ? 'tab-active' : '' }}">
            <x-dynamic-component :component="$tab['icon']" class="w-4 h-4" />
            {{ $tab['label'] }}
        </a>
    @endforeach
</div>
