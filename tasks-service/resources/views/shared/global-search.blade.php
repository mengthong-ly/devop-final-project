<form method="GET" action="{{ $route }}" class="mb-4" id="searchForm">

    <div class="flex gap-2">
        <label class="input rounded-full flex items-center flex-1">
            <x-heroicon-o-magnifying-glass class="w-6 h-6 text-gray-400"></x-heroicon-o-magnifying-glass>
            <input type="text" name="filter[search]" value="{{ request('filter.search') }}"
                placeholder="{{ $placeholder ?? 'Search by name or email...' }}"
                class="grow border-none outline-none bg-transparent" id="searchInput">
            @if (request('filter.search'))
                <a href="{{ request()->url() }}{{ request()->except(['filter', 'page']) ? '?' . http_build_query(request()->except(['filter', 'page'])) : '' }}"
                    class="text-sm text-gray-500 hover:text-gray-700 px-2">
                    <x-heroicon-o-x-mark class="w-4 h-4"></x-heroicon-o-x-mark>
                </a>
            @endif
        </label>

        @if (request('filter.search'))
            <button type="submit" class="btn btn-primary rounded-full">
                Search
            </button>
        @endif
    </div>
</form>
