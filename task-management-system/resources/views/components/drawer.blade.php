@props([
    'drawerId',
    'action' => null,
    'drawerTitle' => '',
    'submitLabel' => 'Save', // default button text
    'cancelLabel' => 'Cancel', // default cancel text
    'method' => 'POST', // form method
])

<div class="drawer drawer-end">
    <input id="{{ $drawerId }}" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content"></div>

    <div class="drawer-side">
        <label for="{{ $drawerId }}" aria-label="close sidebar" class="drawer-overlay"></label>

        <div class="bg-base-100 min-h-screen w-[450px] flex flex-col rounded-l-lg shadow-lg">
            <!-- Header -->
            <div class="p-4 border-b border-base-300">
                <h2 class="font-bold text-xl">{{ $drawerTitle }}</h2>
            </div>

            <!-- Content -->
            {{-- <div class="flex-1 overflow-y-auto p-4 h-screen"> --}}
            @if ($action)
                <form action="{{ $action }}" method="{{ $method }}" enctype="multipart/form-data"
                    class="h-full block">
                    @csrf
                    {{ $slot }}
                </form>
            @else
                <div class="p-4">
                    {{ $slot }}
                </div>
            @endif
            {{-- </div> --}}

            <!-- Footer Action Buttons -->
            {{-- <div class="border-t border-base-300 bg-base-200 p-4 flex justify-end gap-3 sticky bottom-0">
                <div class="btn btn-primary w-full">Save</div>
            </div> --}}
        </div>
    </div>
</div>
