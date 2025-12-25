<header class="py-4 px-8 border-b border-gray-100 shadow-sm sticky top-0 bg-white z-10">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <a href="#" class="text-xl font-bold text-blue-600">YourBrand</a>

        <div class="flex-grow max-w-lg mx-10">
            <div class="relative">
                <input type="text" placeholder="Search products, suppliers, categories..."
                    class="w-full py-2 pl-10 pr-4 text-sm border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        <div class="flex items-center space-x-4">
            <!-- Cart Button -->
            <button class="relative text-gray-600 hover:text-blue-600" onclick="toggleCart()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.64-.18 1.72.71 1.72H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span id="cart-count-badge"
                    class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-blue-500 rounded-full">0</span>
            </button>
            <div class="dropdown dropdown-end">
                <button class="text-gray-600 flex items-center hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="2" y1="12" x2="22" y2="12" />
                        <path d="M12 2a15 15 0 0 1 0 20" />
                        <path d="M12 2a15 15 0 0 0 0 20" />
                    </svg>
                </button>
                <ul tabindex="0"
                    class="dropdown-content menu bg-base-100 rounded-box w-40 p-2 shadow-xl border border-base-200">
                    <li><a id="lang-en-link">🇬🇧 English</a></li>
                    <li><a id="lang-km-link">🇰🇭 ភាសាខ្មែរ</a></li>
                    <li><a id="lang-cn-link">🇨🇳 中文</a></li>
                </ul>
            </div>

            <!-- User Icon -->
            <button class="text-gray-600 hover:text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="7" r="4" />
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                </svg>
            </button>
        </div>
    </div>
</header>

<!-- Side Cart -->
<div id="side-cart"
    class="fixed top-0 right-0 w-full sm:w-96 h-full bg-white shadow-2xl z-50 flex flex-col transform translate-x-full transition-transform duration-300">

    <!-- Cart Header -->
    <div class="p-6 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-900">Your Cart</h2>
        <button onclick="toggleCart()" class="text-gray-400 hover:text-gray-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Cart Items -->
    <div id="cart-items-container" class="flex-grow overflow-y-auto px-6 py-4"></div>

    <!-- Cart Footer -->
    <div class="p-6 border-t border-gray-200">
        <div class="flex justify-between items-center mb-4">
            <div>
                <p class="font-bold text-sm uppercase">SUBTOTAL</p>
                <p class="text-xs text-gray-500 mt-1">Shipping, taxes, and coupon codes calculated at checkout.</p>
            </div>
            <p id="subtotal-display" class="text-lg font-extrabold text-gray-900">$0.00</p>
        </div>

        <form id="checkout-form" method="POST" action="{{ route('phsar.checkout') }}">
            @csrf
            <input type="hidden" name="cartItemsJson" id="cartItemsJson">
            <button type="submit"
                class="w-full flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gray-900 hover:bg-gray-800 transition duration-150 mb-3">
                Checkout
            </button>
        </form>
    </div>
</div>

<div id="topAlert" class="top-alert hidden"></div>

<style>
    .top-alert {
        position: fixed;
        top: 10px;
        left: 50%;
        transform: translateX(-50%);
        background: #ffcc00;
        color: #333;
        padding: 12px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        font-weight: 500;
        z-index: 9999;
        transition: opacity 0.3s ease;
    }

    .top-alert.hidden {
        opacity: 0;
        pointer-events: none;
    }

    .top-alert.show {
        opacity: 1;
    }
</style>
<script>
    function toggleCart() {
        document.getElementById('side-cart').classList.toggle('translate-x-full');
        if (!document.getElementById('side-cart').classList.contains('translate-x-full')) {
            loadCart();
        }
    }

    let cartItems = [];

    // Update cart UI and subtotal
    function updateCart() {
        const container = document.getElementById('cart-items-container');
        container.innerHTML = '';

        let totalAmount = 0;
        let totalQuantity = 0;

        cartItems.forEach((item, index) => {
            totalQuantity += item.quantity;
            const lineTotal = item.price * item.quantity; // unit price * quantity
            totalAmount += lineTotal;

            let optionsStr = item.options.length ? item.options.join(', ') : '';
            const div = document.createElement('div');
            div.classList.add('flex', 'justify-between', 'items-center', 'mb-4');
            div.innerHTML = `
            <div>
                <p class="font-medium">${item.name}</p>
                ${optionsStr ? `<p class="text-xs text-gray-400">${optionsStr}</p>` : ''}
                <p class="text-sm text-gray-500">
                    Price: $${item.price}
            </div>
            <div class="flex flex-row items-center gap-2">
                <button onclick="changeQuantity(${index}, -1)" class="w-8 h-8 flex items-center justify-center bg-gray-200 rounded hover:bg-gray-300 text-lg font-bold">-</button>
                <span class="text-sm font-medium">${String(item.quantity).padStart(2, '0')}</span>
                <button onclick="changeQuantity(${index}, 1)" class="w-8 h-8 flex items-center justify-center bg-gray-200 rounded hover:bg-gray-300 text-lg font-bold">+</button>
                <button onclick="removeFromCart(${index})" class="w-8 h-8 flex items-center justify-center bg-red-500 text-white rounded hover:bg-red-600 font-bold">x</button>
            </div>
        `;
            container.appendChild(div);
        });

        document.getElementById('cart-count-badge').textContent = totalQuantity;
        document.getElementById('subtotal-display').textContent = `$${totalAmount.toFixed(2)}`;

        // Also update hidden form input
        document.getElementById('cartItemsJson').value = JSON.stringify(cartItems);
    }

    // Load cart from backend
    async function loadCart() {
        try {
            const res = await fetch('{{ route("phsar.cart") }}', { headers: { 'Accept': 'application/json' } });
            const data = await res.json();

            if (data.success) {
                // Make sure price is unit price
                cartItems = data.items.map(item => ({
                    line_item_id: item.line_item_id,
                    variant_id: item.variant_id,
                    name: item.product_name,
                    price: parseFloat(item.price),
                    quantity: item.quantity,
                    options: item.options || []
                }));
                updateCart();
            }
        } catch (e) {
            console.error('Failed to load cart', e);
        }
    }


    function renderCartItems() {
        const container = document.getElementById('cart-items-container');
        container.innerHTML = '';

        cartItems.forEach((item, index) => {
            let optionsStr = item.options.length ? item.options.join(', ') : '';
            const div = document.createElement('div');
            div.classList.add('flex', 'justify-between', 'items-center', 'mb-4');
            div.innerHTML = `
            <div>
                <p class="font-medium">${item.name}</p>
                ${optionsStr ? `<p class="text-xs text-gray-400">${optionsStr}</p>` : ''}
                <p class="text-sm text-gray-500">Price: $${item.price.toFixed(2)}</p>
            </div>
            <div class="flex flex-row items-center gap-2">
                <button onclick="changeQuantity(${index}, -1)" class="w-8 h-8 flex items-center justify-center bg-gray-200 rounded hover:bg-gray-300 text-lg font-bold">-</button>
                <span class="text-sm font-medium">${String(item.quantity).padStart(2, '0')}</span>
                <button onclick="changeQuantity(${index}, 1)" class="w-8 h-8 flex items-center justify-center bg-gray-200 rounded hover:bg-gray-300 text-lg font-bold">+</button>
                <button onclick="removeFromCart(${index})" class="w-8 h-8 flex items-center justify-center bg-red-500 text-white rounded hover:bg-red-600 font-bold">x</button>
            </div>
        `;
            container.appendChild(div);
        });
    }

    function changeQuantity(index, delta) {
        const item = cartItems[index];
        if (!item) return;

        const newQuantity = item.quantity + delta;

        if (newQuantity < 0) newQuantity = 0;

        if (newQuantity < 1) {
            removeFromCart(index);
            return;
        }

        // Update frontend instantly
        item.quantity = newQuantity;
        updateCart();

        // Async backend update
        fetch('/phsar/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ variant_id: item.variant_id, quantity: newQuantity })
        }).catch(console.error);
    }

    function removeFromCart(index) {
        const item = cartItems[index];
        if (!item) return;

        // Remove from frontend instantly
        cartItems.splice(index, 1);
        updateCart();

        // Async backend removal
        fetch(`/phsar/cart/remove/${item.line_item_id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        }).catch(console.error);
    }

    function showTopAlert(message, duration = 3000) {
        const alertBox = document.getElementById('topAlert');
        alertBox.textContent = message;
        alertBox.classList.add('show');
        alertBox.classList.remove('hidden');
        setTimeout(() => {
            alertBox.classList.remove('show');
            alertBox.classList.add('hidden');
        }, duration);
    }

    // Initial load
    loadCart();

</script>
