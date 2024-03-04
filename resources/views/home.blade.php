<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold mt-8 mb-4">Menu Items</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($menus as $menu)
                <div class="mb-8">
                    <div class="bg-white rounded-lg shadow-md">
                        <!-- Set a fixed size for the image -->
                        <img src="{{ asset('storage/' . $menu->gambar_menu) }}" class="w-full h-48 object-cover rounded-t-lg" alt="{{ $menu->nama_menu }}">
                        <div class="p-4">
                            <h5 class="text-lg font-semibold">{{ $menu->nama_menu }}</h5>
                            <p class="text-gray-700">Harga: Rp. {{ $menu->harga }}</p>
                            <button class="btn btn-primary mt-2 add-to-cart" data-id="{{ $menu->id }}" data-name="{{ $menu->nama_menu }}" data-price="{{ $menu->harga }}">Add to Cart</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="container mx-auto px-4 mt-8">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="col-span-1">
                <div class="bg-white rounded-lg shadow-md p-4">
                    <h2 class="text-2xl font-bold">Cart</h2>
                    <ul class="mt-4" id="cartItems"></ul>
                    <p class="text-lg font-semibold mt-4">Total Harga: <span id="totalPrice" class="font-bold">0</span></p>
                    <button id="checkoutBtn" class="btn btn-success mt-4"><a href="{{ route('cart') }}" class="btn btn-success mt-4">Next</a></button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartButtons = document.querySelectorAll('.add-to-cart');
            const cartItemsContainer = document.getElementById('cartItems');
            const totalPriceElement = document.getElementById('totalPrice');
            // const checkoutButton = document.getElementById('checkoutBtn');
            let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

            addToCartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-id');
                    const itemName = this.getAttribute('data-name');
                    const itemPrice = parseFloat(this.getAttribute('data-price'));

                    const itemExistsInCart = cartItems.find(item => item.id === itemId);
                    if (itemExistsInCart) {
                        itemExistsInCart.quantity++;
                    } else {
                        cartItems.push({ id: itemId, name: itemName, price: itemPrice, quantity: 1 });
                    }

                    updateCartDisplay();
                    updateLocalStorage();
                });
            });

            function updateCartDisplay() {
                cartItemsContainer.innerHTML = '';
                let totalPrice = 0;

                cartItems.forEach(item => {
                    const listItem = document.createElement('li');
                    listItem.innerHTML = `
                        <span>${item.name} x ${item.quantity} - Rp. ${item.price.toFixed(3)}</span>
                        <button class="btn btn-sm btn-primary decrease" data-id="${item.id}">-</button>
                        <button class="btn btn-sm btn-danger delete" data-id="${item.id}">Delete</button>
                    `;
                    cartItemsContainer.appendChild(listItem);
                    totalPrice += item.price * item.quantity;
                });

                totalPriceElement.textContent = 'Rp. ' + totalPrice.toFixed(3);
            }

            function updateLocalStorage() {
                localStorage.setItem('cartItems', JSON.stringify(cartItems));
            }

            cartItemsContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('decrease')) {
                    const itemId = event.target.getAttribute('data-id');
                    const itemIndex = cartItems.findIndex(item => item.id === itemId);
                    if (cartItems[itemIndex].quantity > 1) {
                        cartItems[itemIndex].quantity--;
                        updateCartDisplay();
                        updateLocalStorage();
                    }
                }

                if (event.target.classList.contains('delete')) {
                    const itemId = event.target.getAttribute('data-id');
                    cartItems = cartItems.filter(item => item.id !== itemId);
                    updateCartDisplay();
                    updateLocalStorage();
                }
            });

            updateCartDisplay();
        });
    </script>
</x-app-layout>
