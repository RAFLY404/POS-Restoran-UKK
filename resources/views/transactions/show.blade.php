
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Button for Exporting to PDF -->
                    <div class="mb-4">
                        <form action="{{ route('exportpdf') }}" method="post">
                            @csrf
                        </form>
                    </div>
                    <h2 class="text-xl font-semibold mb-4"><b>Data Penjualan</b></h2>
                    <div class="mb-4">
                        <p><b>Total Transaksi Berhasil Bulan Ini:</b> {{ $totalTransaksi }}</p>
                        <p><b>Pendapatan Bulan Ini:</b> {{ $totalHarga }}</p>
                        <p><b>Jumlah Item Terjual:</b> {{ $totalQuantity }}</p>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Jumlah Penjualan Per-Item:</h3>
                    <table class="table" style="width: 100%; border-collapse: collapse;">
                        <thead style="background-color: #f3f4f6;">
                            <tr>
                                <th style="padding: 8px; text-align: left;">No.</th>
                                <th style="padding: 8px; text-align: left;">Nama Produk</th>
                                <th style="padding: 8px; text-align: left;">Total Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($totalQuantityPerProduk as $index => $item)
                            <tr>
                                <td style="border: 1px solid #ddd; padding: 8px;">{{ $index + 1 }}</td>
                                <td style="border: 1px solid #ddd; padding: 8px;">{{ $item->menu }}</td>
                                <td style="border: 1px solid #ddd; padding: 8px;">{{ $item->total_quantity }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

