<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Transaksi') }}
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 bg-white border-b border-gray-200">
                    <!-- Button for Exporting to PDF -->
                    <div class="mb-4 text-center">
                        <form action="{{ route('exportpdf') }}" method="post">
                            @csrf
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Export to PDF
                            </button>
                        </form>
                    </div>
                    <h2 class="text-lg font-semibold mb-2">Data Penjualan Bulan Ini</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="border border-gray-200 rounded-lg p-4">
                            <p><b>Total Transaksi:</b> {{ $totalTransaksi }}</p>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4">
                            <p><b>Pendapatan:</b> {{ $totalHarga }}</p>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4">
                            <p><b>Jumlah Item Terjual:</b> {{ $totalQuantity }}</p>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold mt-6 mb-2">Jumlah Penjualan Per-Item:</h3>
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="px-4 py-2">No.</th>
                                    <th class="px-4 py-2">Nama Produk</th>
                                    <th class="px-4 py-2">Total Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($totalQuantityPerProduk as $index => $item)
                                <tr>
                                    <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                    <td class="border px-4 py-2">{{ $item->menu }}</td>
                                    <td class="border px-4 py-2">{{ $item->total_quantity }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
