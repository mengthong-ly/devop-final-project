@php
    $isSupplier ?? false;
@endphp

<div role="tablist" class="tabs tabs-border m-0 p-0">
    <a role="tab" href="{{ route('supplier.register') }}" class="tab {{ $isSupplier ? 'tab-active' : '' }} ">Supplier</a>
    <a role="tab" href="{{ route('register') }}" class="tab {{ !$isSupplier ? 'tab-active' : '' }}">Customer</a>
</div>
