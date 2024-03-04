<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Transaksi') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-6 px-4 sm:px-6 lg:px-10">
        <!-- Button for Sales Report -->
        <div class="flex justify-end mb-4">
            <a href="{{ route('laporan') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Laporan Penjualan</a>
        </div>

        <div class="overflow-x-auto w-[1280px]">
            <div class="py-4 align-middle inline-block min-w-full">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <div class="flex justify-between items-center px-6 py-4">
                        <div class="w-full sm:max-w-xs">
                            <label for="search" class="sr-only">Search</label>
                            <input id="search" type="text" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Search..." />
                        </div>
                        <div class="w-full sm:max-w-xs ml-4">
                            <label for="statusFilter" class="sr-only">Status Filter</label>
                            <select id="statusFilter" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                <option value="all">All</option>
                                <option value="pending">Pending</option>
                                <option value="success">Success</option>
                                <option value="failed">Failed</option>
                            </select>
                        </div>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Order ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Pelanggan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Transaction Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Gross Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Payment Method</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Transaction Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Payment Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach ($transactions as $transaction)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->order_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->user_id ? $transaction->user_id : 'Guest' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->nama_pelanggan}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->tanggal_transaksi }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->gross_amount }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->payment_method }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->status_transaction }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->status_payment }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button type="button" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 mr-2" data-toggle="modal" data-target="#transactionModal{{ $transaction->id }}">View Details</button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if ($transaction->status_payment === 'SUCCESS' && $transaction->status_transaction !== 'selesai')
                                    <form action="{{ route('update.transaction.status', $transaction->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300">Update</button>
                                    </form>
                                    @elseif ($transaction->status_transaction === 'selesai')
                                    <!-- Tidak melakukan apa pun jika status transaksi sudah 'selesai' -->
                                    @else
                                    <span class="text-red-400">Denied</span>
                                    @endif
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
            {{ $transactions->links() }}
        </div>
    </div>

    @foreach ($transactions as $transaction)
    <!-- Modal -->
    <div class="modal fade" id="transactionModal{{ $transaction->id }}" tabindex="-1" role="dialog" aria-labelledby="transactionModalLabel{{ $transaction->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transactionModalLabel{{ $transaction->id }}">Transaction Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>ID: {{ $transaction->id }}</p>
                    <p>Order ID: {{ $transaction->order_id }}</p>
                    <p>User ID: {{ $transaction->user_id ? $transaction->user_id : 'Guest' }}</p>
                    <p>Nama Pelanggan: {{ $transaction->nama_pelanggan}}</p>
                    <p>Nomor Meja: {{ $transaction->nomor_meja }}</p>
                    <br>
                    <h2 class="font-bold">Transaction Items : </h2>
                    <ul>
                        @foreach ($transaction->details as $detail)
                        <li>Menu: {{ $detail->menu->nama_menu }}, Price: Rp. {{ $detail->price }},
                            <li>Quantity: {{ $detail->quantity }}</li>
                            @endforeach
                            <p>Total harga : Rp. {{ $transaction->gross_amount }}</p>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</x-app-layout>

<!-- JavaScript for search and status filter functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const statusFilterSelect = document.getElementById('statusFilter');
        const tableRows = document.getElementById('tableBody').getElementsByTagName('tr');

        searchInput.addEventListener('input', function() {
            filterTransactions();
        });

        statusFilterSelect.addEventListener('change', function() {
            filterTransactions();
        });

        function filterTransactions() {
            const searchString = searchInput.value.toLowerCase();
            const selectedStatus = statusFilterSelect.value.toLowerCase();

            Array.from(tableRows).forEach(function(row) {
                const transactionStatus = row.cells[7].textContent.toLowerCase(); // Assuming transaction status is in the eighth cell
                const paymentStatus = row.cells[8].textContent.toLowerCase(); // Assuming payment status is in the ninth cell

                const textContent = row.textContent.toLowerCase();
                const statusMatch = selectedStatus === 'all' || (transactionStatus === selectedStatus || paymentStatus === selectedStatus);

                if (statusMatch && textContent.includes(searchString)) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    });
</script>
