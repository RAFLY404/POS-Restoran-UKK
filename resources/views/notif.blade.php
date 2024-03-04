<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Midtrans Notification') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-6 px-4 sm:px-6 lg:px-10">

        <div class="overflow-x-auto w-[1280px]">
            <div class="py-4 align-middle inline-block min-w-full">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <div class="flex justify-between items-center px-6 py-4">
                        <div class="w-full sm:max-w-xs">
                            <label for="search" class="sr-only">Search</label>
                            <input id="search" type="text" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Search..." />
                        </div>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                               <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Transaction Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Transaction Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Transaction Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Transaction Id</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status Message</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Signature Key</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Settlement Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Reference Id</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Payment Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Order Id</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Merchant Id</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Issuer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Gross Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fraud Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Expiry Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cureency</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acquirer</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach ($notifs as $transaction)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->transaction_type }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->transaction_time }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->transaction_status}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->transaction_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->status_message }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->status_code }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->signature_key }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->settlement_time }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->reference_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->payment_type }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->order_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->merchant_id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->issuer }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->gross_amount }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->fraud_status }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->expiry_time }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->currency }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">{{ $transaction->acquirer }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<div id="myModal" class="modal fixed w-full h-full top-0 left-0 items-center justify-center z-50 hidden">
    <!-- Modal content -->
    <div class="modal-content bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-hidden">
        <span class="close absolute top-0 right-0 cursor-pointer mt-4 mr-4 text-lg font-semibold">&times;</span>
        <div id="modalContent" class="modal-body p-4 overflow-y-auto"></div>
    </div>
</div>

<!-- JavaScript for modal functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the modal
        var modal = document.getElementById('myModal');

        // Get the <span> element that closes the modal
        var span = document.querySelector('.close');

        // When the user clicks on a row, open the modal
        var tableRows = document.getElementById('tableBody').getElementsByTagName('tr');
        Array.from(tableRows).forEach(function(row) {
            row.addEventListener('click', function() {
                var modalContent = document.getElementById('modalContent');
                modalContent.innerHTML = generateModalContent(row);
                modal.style.display = "flex";
            });
        });

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Function to generate modal content
        function generateModalContent(row) {
            var content = '<div class="modal-header pb-2 border-b">';
            content += '<h2 class="text-lg font-semibold">Notification Details</h2>';
            content += '</div>';
            content += '<div class="modal-body py-4">';
            content += '<p><strong>Transaction Type:</strong> ' + row.cells[0].textContent + '</p>';
            content += '<p><strong>Transaction Time:</strong> ' + row.cells[1].textContent + '</p>';
            content += '<p><strong>Transaction Status:</strong> ' + row.cells[2].textContent + '</p>';
            content += '<p><strong>Transaction ID:</strong> ' + row.cells[3].textContent + '</p>';
            content += '<p><strong>Status Message:</strong> ' + row.cells[4].textContent + '</p>';
            content += '<p><strong>Status Code:</strong> ' + row.cells[5].textContent + '</p>';
            content += '<p><strong>Signature Key:</strong> ' + row.cells[6].textContent + '</p>';
            content += '<p><strong>Settlement Time:</strong> ' + row.cells[7].textContent + '</p>';
            content += '<p><strong>Reference ID:</strong> ' + row.cells[8].textContent + '</p>';
            content += '<p><strong>Payment Type:</strong> ' + row.cells[9].textContent + '</p>';
            content += '<p><strong>Order ID:</strong> ' + row.cells[10].textContent + '</p>';
            content += '<p><strong>Merchant ID:</strong> ' + row.cells[11].textContent + '</p>';
            content += '<p><strong>Issuer:</strong> ' + row.cells[12].textContent + '</p>';
            content += '<p><strong>Gross Amount:</strong> ' + row.cells[13].textContent + '</p>';
            content += '<p><strong>Fraud Status:</strong> ' + row.cells[14].textContent + '</p>';
            content += '<p><strong>Expiry Time:</strong> ' + row.cells[15].textContent + '</p>';
            content += '<p><strong>Currency:</strong> ' + row.cells[16].textContent + '</p>';
            content += '<p><strong>Acquirer:</strong> ' + row.cells[17].textContent + '</p>';
            content += '</div>';
            return content;
        }
    });
</script>

</x-app-layout>
