@if ($items->hasPages())
    <div class="flex mt-4">
        <div class="join">
            {{-- Previous Page Link --}}
            @if ($items->onFirstPage())
                <button class="join-item btn btn-disabled">«</button>
            @else
                <a href="{{ $items->previousPageUrl() }}" class="join-item btn">«</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
                @if ($page == $items->currentPage())
                    <button class="join-item btn btn-active">{{ $page }}</button>
                @else
                    <a href="{{ $url }}" class="join-item btn">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($items->hasMorePages())
                <a href="{{ $items->nextPageUrl() }}" class="join-item btn">»</a>
            @else
                <button class="join-item btn btn-disabled">»</button>
            @endif
        </div>
    </div>
@endif
