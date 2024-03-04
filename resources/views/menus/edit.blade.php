<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Menu') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200 dark:border-gray-600">
                <form action="{{ route('menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-6">
                        <div>
                            <label for="nama_menu" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Menu</label>
                            <input type="text" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" id="nama_menu" name="nama_menu" value="{{ $menu->nama_menu }}" required>
                        </div>

                        <div>
                            <label for="current_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Current Image</label>
                            @if ($menu->gambar_menu)
                                <div class="mt-1">
                                    <img src="{{ asset('storage/' . $menu->gambar_menu) }}" alt="{{ $menu->nama_menu }}" class="max-w-xs">
                                </div>
                            @else
                                <div>No Image</div>
                            @endif
                        </div>

                        <div>
                            <label for="gambar_menu" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Choose New Image (Optional)</label>
                            <input type="file" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" id="gambar_menu" name="gambar_menu" accept="image/*">
                        </div>

                        <div>
                            <label for="harga" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga</label>
                            <input type="number" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" id="harga" name="harga" value="{{ $menu->harga }}" required>
                        </div>

                        <div>
                            <label for="kategori" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori</label>
                            <select class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" id="kategori" name="kategori" required>
                                <option value="makanan" {{ $menu->kategori == 'makanan' ? 'selected' : '' }}>Makanan</option>
                                <option value="minuman" {{ $menu->kategori == 'minuman' ? 'selected' : '' }}>Minuman</option>
                                <option value="snack" {{ $menu->kategori == 'snack' ? 'selected' : '' }}>Snack</option>
                            </select>
                        </div>

                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
