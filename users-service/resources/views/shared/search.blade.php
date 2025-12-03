<form method="GET" action="{{ $route }}" class="mb-4" id="searchForm">
    <div class="flex gap-2">
        <label class="input rounded-full flex items-center">
            <x-heroicon-o-magnifying-glass class="w-6 h-6"></x-heroicon-o-magnifying-glass>
            {{-- the search is variable and the value is what will the input get the value from the params to put into --}}
            <input type="text" name="filter[search]" value="{{ request('filter.search') }}" placeholder="Search"
                class="input input-bordered flex items-center bg-base-100" id="searchInput">
            <a href="{{ $route }}" class=" text-sm text-base-content rounded-full pr-1">
                Clear
            </a>
        </label>
    </div>
</form>
