<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Histori') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-6 px-4 sm:px-6 lg:px-8">
        <div class="overflow-x-auto">
            <div class="py-4 align-middle inline-block min-w-full">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Order ID</th>
                                {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User ID</th> --}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Pelanggan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Transaction Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Gross Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Payment Method</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Transaction Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Payment Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach ($data as $transaction)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->order_id }}</td>
                                {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->user_id ? $transaction->user_id : 'Guest' }}</td> --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->nama_pelanggan}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->tanggal_transaksi }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->gross_amount }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->payment_method }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->status_transaction }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->status_payment }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button type="button" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 mr-2" data-toggle="modal" data-target="#transactionModal{{ $transaction->id }}">View Details</button>
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
            {{ $data->links() }}
        </div>
    </div>

    @foreach ($data as $transaction)
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
                    {{-- <p>ID: {{ $transaction->id }}</p> --}}
                    <p>Order ID: {{ $transaction->order_id }}</p>
                    {{-- <p>User ID: {{ $transaction->user_id ? $transaction->user_id : 'Guest' }}</p> --}}
                    <p>Nama Pelanggan: {{ $transaction->nama_pelanggan}}</p>
                    <p>Nomor Meja: {{ $transaction->nomor_meja }}</p>
                    <br>
                    <h2 class="font-bold">Transaction Items : </h2>
                    <ul>
                        @foreach ($transaction->details as $detail)
                            <li>Menu: {{ $detail->menu->nama_menu }}, Price: Rp. {{ $detail->price }}, Quantity: {{ $detail->quantity }}</li>
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
