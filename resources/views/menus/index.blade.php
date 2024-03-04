<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Menu') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-5 px-4 sm:px-6 lg:px-8">
        <div class="overflow-x-auto">
            <div class="py-4 align-middle inline-block min-w-full">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <div class="flex justify-between items-center px-4 py-3 bg-gray-50 dark:bg-gray-700">
                        <div>
                            <a href="{{ route('menus.create') }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded sm:mr-2">Tambah Menu</a>
                        </div>
                        <div class="flex-1 ml-4">
                            <label for="search" class="sr-only">Search</label>
                            <input type="text" id="search" name="search" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Search...">
                        </div>
                        <div class="ml-4">
                            <label for="sortKategori" class="sr-only">Sort by Kategori</label>
                            <select id="sortKategori" name="sortKategori" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <option value="all">All</option>
                                <option value="makanan">Makanan</option>
                                <option value="minuman">Minuman</option>
                                <option value="snack">Snack</option>
                                <!-- Add more categories as needed -->
                            </select>
                        </div>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Menu</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Harga</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kategori</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Gambar</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @php
                                $counter = 1;
                            @endphp
                            @foreach($menus as $menu)
                                <tr class="menuRow" data-kategori="{{ $menu->kategori }}">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $counter++ }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $menu->nama_menu }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $menu->harga }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $menu->kategori }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                        @if ($menu->gambar_menu)
                                            <img src="{{ asset('storage/' . $menu->gambar_menu) }}" alt="{{ $menu->nama_menu }}" class="h-8 w-8 object-cover rounded-full">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('menus.edit', $menu->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 mr-2">Edit</a>
                                        <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Pagination -->
        <div class="py-4">
            {{ $menus->links() }}
        </div>
    </div>

    <!-- JavaScript for search and sort functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const sortKategori = document.getElementById('sortKategori');
            const tableBody = document.getElementById('tableBody').getElementsByTagName('tr');

            searchInput.addEventListener('input', function() {
                filterMenus();
            });

            sortKategori.addEventListener('change', function() {
                filterMenus();
            });

            function filterMenus() {
                const searchString = searchInput.value.toLowerCase();
                const selectedKategori = sortKategori.value;

                Array.from(tableBody).forEach(function(row) {
                    const kategori = row.getAttribute('data-kategori').toLowerCase();
                    const textContent = row.textContent.toLowerCase();

                    if ((selectedKategori === 'all' || kategori === selectedKategori) && textContent.includes(searchString)) {
                        row.style.display = 'table-row';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
        });
    </script>
</x-app-layout>
