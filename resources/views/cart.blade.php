<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pesan kasir') }}
        </h2>
    </x-slot>




<div class="container mx-auto px-4 ">
    <h2 class="text-2xl font-bold mt-8 mb-4">Menu Items</h2>
            <!-- Filter Kategori -->
    <div class="mb-4">
        <label for="categoryFilter" class="text-lg font-semibold">Filter by Category:</label>
        <select id="categoryFilter" onchange="filterMenuByCategory(this.value)" class="form-select mt-2">
            <option value="all">All Categories</option>
            <option value="makanan">Makanan</option>
            <option value="minuman">Minuman</option>
            <option value="snack">Snack</option>
        </select>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($menus as $menu)
            <div class="mb-8 menu-item" data-category="{{ $menu->kategori }}">
                    <div class="bg-white rounded-lg shadow-md">
                    <!-- Set a fixed size for the image -->
                    <img src="{{ asset('storage/' . $menu->gambar_menu) }}" class="w-full h-48 object-cover rounded-t-lg" alt="{{ $menu->nama_menu }}">
                    <div class="p-4">
                        <h5 class="text-lg font-semibold">{{ $menu->nama_menu }}</h5>
                        <p class="text-gray-700">Harga: Rp. {{ $menu->harga }}</p>
                        <button onclick="addToCart('{{ $menu->id }}', '{{ $menu->nama_menu }}', '{{ $menu->harga }}')" class="btn btn-primary mt-2 add-to-cart" data-id="{{ $menu->id }}" data-name="{{ $menu->nama_menu }}" data-price="{{ $menu->harga }}">Add to Cart</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="w-full mt-10 max-h-[230px]">
    <div class="col-span-1">
        <div class="bg-white rounded-lg shadow-md p-4">
            <h2 class="text-lg font-semibold mb-2">Cart</h2>
            <div class="">
                <table class="">
                    <thead>
                        <tr>
                            <th class="px-3 py-2">Nama Menu</th>
                            <th class="px-3 py-2">Harga</th>
                            <th class="px-3 py-2">QTY</th>
                            <th class="px-3 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="cart-items" class="">
                        <!-- Daftar produk dalam keranjang belanja akan ditambahkan secara dinamis di sini -->
                    </tbody>
                </table>
            </div>
            <div class="mt-4 sticky bottom-0 bg-white flex flex-col sm:flex-row justify-between items-center">
                <form action="/checkoutKasir" method="POST" id="checkout-form" class="flex flex-wrap items-center justify-center sm:justify-between w-full">
                    @csrf
                    <input type="hidden" name="items" id="items-field">
                    <input type="hidden" name="gross_amount" id="gross-amount-field">
                    <label for="table_number" class="block text-gray-700 font-bold mb-2 mr-2 sm:mb-0">Nomor Meja:</label>
                    <select name="table_number" id="table_number" class="form-select rounded-md w-full sm:w-auto mb-2 sm:mb-0">
                        <option value="Meja 1">Meja 1</option>
                        <option value="Meja 2">Meja 2</option>
                        <option value="Meja 3">Meja 3</option>
                        <option value="Meja 4">Meja 4</option>
                        <option value="Meja 5">Meja 5</option>
                    </select>
                    <label for="customer_name" class="block text-gray-700 font-bold mb-2 mr-2 sm:mb-0">Nama Pelanggan:</label>
                    <input type="text" name="customer_name" placeholder="Ex. Fransiska" id="customer_name" class="form-input rounded-md w-full sm:w-auto mb-2 sm:mb-0" required>
                    <button onclick="openMidtransPopup()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2 sm:mt-0">Bayar Sekarang</button>
                </form>
                <p class="text-sm font-semibold mt-2 sm:mt-0">Total Harga: <span id="totalPrice" class="font-bold">0</span></p>
            </div>
        </div>
    </div>
</div>







</x-app-layout>
<script>
    function addToCart(productId, productName, productPrice) {
        let existingCartItem = document.getElementById("item-" + productId);
        if (existingCartItem) {
            // Jika item sudah ada dalam keranjang, tingkatkan jumlahnya
            let quantityElement = existingCartItem.querySelector("td.quantity");
            let currentQuantity = parseInt(quantityElement.innerText);
            quantityElement.innerText = currentQuantity + 1;
        } else {
            // Jika item belum ada dalam keranjang, tambahkan sebagai item baru
            let cartItem = document.createElement("tr");
            cartItem.setAttribute("id", "item-" + productId);
            cartItem.innerHTML = `
            <td>${productName}</td>
            <td>${productPrice}</td>
            <td class="quantity">1</td>
            <td class="actions">
                <div class="flex flex-row justify-center items-center">
                    <button onclick="reduceItem('${productId}')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded mr-1">-</button>
                    <button onclick="addItem('${productId}')" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded mr-1">+</button>
                    <button onclick="removeItem('${productId}')" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </td>






            `;
            document.getElementById("cart-items").appendChild(cartItem);
        }
        calculateTotal();
    }

    function removeItem(productId) {
        let cartItem = document.getElementById("item-" + productId);
        cartItem.parentNode.removeChild(cartItem);
        calculateTotal();
    }

    // Fungsi lainnya tidak berubah

    function addItem(productId) {
    let quantityElement = document.getElementById("item-" + productId).querySelector(".quantity");
    let currentQuantity = parseInt(quantityElement.innerText);
    quantityElement.innerText = currentQuantity + 1;
    calculateTotal();
}

function reduceItem(productId) {
    let quantityElement = document.getElementById("item-" + productId).querySelector(".quantity");
    let currentQuantity = parseInt(quantityElement.innerText);
    if (currentQuantity > 1) {
        quantityElement.innerText = currentQuantity - 1;
        calculateTotal();
    }
}

    function calculateTotal() {
        let cartItems = document.getElementById("cart-items").children;
        let totalPrice = 0;
        for (let i = 0; i < cartItems.length; i++) {
            let quantityElement = cartItems[i].querySelector("td.quantity");
            let currentQuantity = parseInt(quantityElement.innerText);
            let priceElement = cartItems[i].querySelector("td:nth-child(2)").innerText;
             let price = parseFloat(priceElement.replace(/[^0-9.-]+/g,""));
            totalPrice += currentQuantity * price;
        }
        document.getElementById("totalPrice").innerText = 'Rp. ' + totalPrice;
    }
   function clearCart() {
        let cartItems = document.getElementById("cart-items");
        cartItems.innerHTML = "";
        calculateTotal();
    }

    function prepareCheckout() {
    let cartItems = [];
    let totalPrice = 0;
    let items = document.getElementById("cart-items").children;
    for (let i = 0; i < items.length; i++) {
        let productId = items[i].getAttribute("id").split("-")[1];
        let productName = items[i].querySelector("td:nth-child(1)").innerText;
        let productPrice = parseFloat(items[i].querySelector("td:nth-child(2)").innerText);
        let quantity = parseInt(items[i].querySelector(".quantity").innerText);
        cartItems.push({
            id_produk: productId,
            nama_produk: productName,
            harga: productPrice,
            jumlah: quantity
        });
        totalPrice += productPrice * quantity;
    }

    document.getElementById("items-field").value = JSON.stringify(cartItems);
    document.getElementById("gross-amount-field").value = totalPrice; // Mengisi nilai gross_amount
}

function checkout() {
    prepareCheckout(); // Pastikan gross_amount terisi sebelum form disubmit
    document.getElementById("checkout-form").submit();
}

function openMidtransPopup() {
    prepareCheckout(); 

    
    let snapToken = document.getElementById("snap-token-field").value;

    // Memanggil Snap.js untuk membuka popup pembayaran
    snap.pay(snapToken, {
        onSuccess: function(result) {
            console.log('Payment successful:', result);
            windows.href('/');
        },
        onPending: function(result) {
            console.log('Payment pending:', result);

        },
        onError: function(result) {
            console.log('Payment error:', result);

        }
    });
}

        function filterMenuByCategory(category) {
            let menuItems = document.querySelectorAll('.menu-item');

            menuItems.forEach(item => {
                if (category === 'all' || item.dataset.category === category) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

</script>
