<form method="GET" action="{{ $route }}" class="w-full sm:w-auto" id="searchForm">
    <div class="flex gap-2">
        <div class="input input-bordered flex items-center gap-2 bg-base-100 w-full sm:w-80">
            <x-heroicon-o-magnifying-glass class="w-4 h-4 text-base-content/50"></x-heroicon-o-magnifying-glass>
            <input type="text" name="filter[search]" value="{{ request('filter.search') }}"
                placeholder="{{ $placeholder ?? 'Search...' }}" class="grow bg-transparent border-0 outline-none"
                id="searchInput">
            @if (request('filter.search'))
                <a href="{{ $route }}" class="text-sm text-base-content/60 hover:text-base-content">
                    <x-heroicon-o-x-mark class="w-4 h-4" />
                </a>
            @endif
        </div>
    </div>
</form>
