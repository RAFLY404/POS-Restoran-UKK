<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Notif;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class TransactionController extends Controller
{
     public function index()
    {
        $transactions = Transaction::orderBy('id', 'desc')->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }




public function updateStatus($id)
{
    $transaction = Transaction::findOrFail($id);
    
    // Lakukan validasi status transaksi di sini jika diperlukan

    $transaction->update(['status_transaction' => 'selesai']);

    return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui.');
}


public function checkoutKasir(Request $request)
{
    $items = json_decode($request->items, true);

    $order_id = 'RMR-' . date('YmdHis');

    // Simpan transaksi
    $transaksi = new Transaction();
    $transaksi->user_id = null;
    $transaksi->nama_pelanggan = $request->customer_name; 
    $transaksi->order_id = $order_id; 
    $transaksi->gross_amount = $request->gross_amount; 
    $transaksi->payment_method = 'CASH'; 
    $transaksi->status_payment = 'SUCCESS'; 
    $transaksi->status_transaction = 'proses'; 
    $transaksi->nomor_meja = $request->table_number; 
    $transaksi->save();

    // Simpan detail transaksi
    foreach ($items as $item) {
        $transaksiDetail = new TransactionDetail();
        $transaksiDetail->transaction_id = $transaksi->id; 
        $transaksiDetail->item_id = $item['id_produk'];
        $transaksiDetail->quantity = $item['jumlah'];
        $transaksiDetail->price = $item['harga'] * $item['jumlah'];
        $transaksiDetail->save();
    }
}


public function checkoutp(Request $request)
{
    $items = json_decode($request->items, true);

    $order_id = 'RMR-' . date('YmdHis');

    // Simpan transaksi
    $transaksi = new Transaction();
    if (auth()->check()) {
        $transaksi->user_id = auth()->user()->id;
    } else {
        $transaksi->user_id = null;
    }
    $transaksi->nama_pelanggan = $request->customer_name; 
    $transaksi->order_id = $order_id; 
    $transaksi->gross_amount = $request->gross_amount; 
    $transaksi->payment_method = 'CASHLESS'; 
    $transaksi->status_payment = 'PENDING'; 
    $transaksi->status_transaction = 'proses'; 
    $transaksi->nomor_meja = $request->table_number; 
    $transaksi->save();

    // Simpan detail transaksi
    foreach ($items as $item) {
        $transaksiDetail = new TransactionDetail();
        $transaksiDetail->transaction_id = $transaksi->id; 
        $transaksiDetail->item_id = $item['id_produk'];
        $transaksiDetail->quantity = $item['jumlah'];
        $transaksiDetail->price = $item['harga'] * $item['jumlah'];
        $transaksiDetail->save();
    }

       
        // Set your Merchant Server Key
       Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
       Config::$isProduction = false;
        // Set sanitization on (default)
       Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
       Config::$is3ds = true;

        // Buat array untuk item pembelian
        $itemsMidtrans = [];
        foreach ($items as $item) {
            $itemsMidtrans[] = [
                'id' => $item['id_produk'],
                'price' => $item['harga'],
                'quantity' => $item['jumlah'],
                'name' => $item['nama_produk']
            ];
        }

        // Buat array payload untuk permintaan pembayaran ke Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $transaksi->order_id,
                'gross_amount' => $transaksi->gross_amount,
            ],
            'item_details' => $itemsMidtrans,
            'customer_details' => [
                'first_name' => $request->customer_name,
                'email' => $request->customer_email,
            ],
        ];

        
        // if (auth()->check()) {
        //     $params['customer_details']['first_name'] = auth()->user()->name;
        //     $params['customer_details']['email'] = auth()->user()->email;
        // }
       
        $snapToken = Snap::getSnapToken($params);

        // Buat URL pembayaran Midtrans berdasarkan token Snap
        $midtransPaymentUrl = 'https://app.sandbox.midtrans.com/snap/v3/redirection/' . $snapToken;

        // Redirect pengguna ke halaman pembayaran Midtrans
        return Redirect::away($midtransPaymentUrl);
    }

public function callback(Request $request)
{
    $orderId = "$request->order_id";
    $statusCode = "$request->status_code";
    $grossAmount = "$request->gross_amount";
    $serverKey = config('midtrans.serverKey');
    $input = $orderId.$statusCode.$grossAmount.$serverKey;
    $hashed = openssl_digest($input, 'sha512');

    if($hashed === $request->signature_key){
        if($request->transaction_status == 'settlement'){ 
            $transaction = Transaction::where('order_id', $request->order_id)->first();
            if($transaction){
                $transaction->update(['status_payment' => 'SUCCESS']);-
                $transaction->update(['payment_method' => $request->payment_type]);


                $transaction = new Notif();

                $transaction->transaction_type = $request->transaction_type;
                $transaction->transaction_time = $request->transaction_time;
                $transaction->transaction_status = $request->transaction_status;
                $transaction->transaction_id = $request->transaction_id;
                $transaction->status_message = $request->status_message;
                $transaction->status_code = $request->status_code;
                $transaction->signature_key = $request->signature_key;
                $transaction->settlement_time = $request->settlement_time;
                $transaction->reference_id = $request->reference_id;
                $transaction->payment_type = $request->payment_type;
                $transaction->order_id = $request->order_id;
                $transaction->merchant_id = $request->merchant_id;
                $transaction->issuer = $request->issuer;
                $transaction->gross_amount = $request->gross_amount;
                $transaction->fraud_status = $request->fraud_status;
                $transaction->expiry_time = $request->expiry_time;
                $transaction->currency = $request->currency;
                $transaction->acquirer = $request->acquirer;

                $transaction->save();

                return response()->json(['message' => 'Status pembayaran berhasil diperbarui'], 200);
            } else {
                return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
            }
        }  elseif ($request->transaction_status == 'deny' || $request->transaction_status == 'cancel' || $request->transaction_status == 'expire') {
            
            $this->processDenyOrCancelOrExpire($orderId);
        }
    } else {
        return response()->json(['message' => 'Signature key is not valid'], 401);
    }
        
    }
        private function processDenyOrCancelOrExpire($orderId)
    {
        $order = Transaction::where('order_id', $orderId)->first();
        if ($order) {
            $order->update(['status_payment' => 'failed']);
            $order->update(['status_transaction' => 'failed']);
        }
    }


    public function viewLaporan(){
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $totalTransaksi = Transaction::where('status_payment', 'SUCCESS')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        $totalHarga = Transaction::where('status_payment', 'SUCCESS')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('gross_amount');

        $totalQuantityPerProduk = TransactionDetail::join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->join('menus', 'transaction_details.item_id', '=', 'menus.id')
            ->where('status_payment', 'SUCCESS')
            ->whereBetween('transactions.created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('menus.id')
            ->selectRaw('MAX(menus.nama_menu) as menu, sum(transaction_details.quantity) as total_quantity')
            ->get();

        $totalQuantity = TransactionDetail::join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->where('status_payment', 'SUCCESS')
            ->whereBetween('transactions.created_at', [$startOfMonth, $endOfMonth])
            ->sum('quantity');

        // Load view 'historySuccess' into a variable
        return view('laporan', compact('totalTransaksi', 'totalHarga', 'totalQuantityPerProduk', 'totalQuantity'));

    }



    public function exportPDF()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $totalTransaksi = Transaction::where('status_payment', 'SUCCESS')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        $totalHarga = Transaction::where('status_payment', 'SUCCESS')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('gross_amount');

        $totalQuantityPerProduk = TransactionDetail::join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->join('menus', 'transaction_details.item_id', '=', 'menus.id')
            ->where('status_payment', 'SUCCESS')
            ->whereBetween('transactions.created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('menus.id')
            ->selectRaw('MAX(menus.nama_menu) as menu, sum(transaction_details.quantity) as total_quantity')
            ->get();

        $totalQuantity = TransactionDetail::join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->where('status_payment', 'SUCCESS')
            ->whereBetween('transactions.created_at', [$startOfMonth, $endOfMonth])
            ->sum('quantity');

        // Load view 'historySuccess' into a variable
        $view = view('transactions.show', compact('totalTransaksi', 'totalHarga', 'totalQuantityPerProduk', 'totalQuantity'))->render();

        // Create Dompdf instance
        $dompdf = new Dompdf();

        // Load HTML content
        $dompdf->loadHtml($view);

        // Render PDF
        $dompdf->render();

        // Output PDF as download
        return $dompdf->stream('laporan_penjualan.pdf');
    }

    public function notif()
    {
        $notifs = Notif::all();
        return view('notif', compact('notifs'));
    }

};
