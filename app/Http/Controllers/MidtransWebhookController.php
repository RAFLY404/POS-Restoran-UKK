<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Order;
use Midtrans\Notification;
use App\Models\Transaction;
use Illuminate\Http\Request;

class MidtransWebhookController extends Controller
{
    public function callback(Request $request){
    $serverKey = config('midtrans.server_key');
    $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);

    if($hashed == $request->signature_key){
        if($request->transaction_status == 'settlement'){
            // Find the transaction by order_id
            $transaction = Transaction::where('id', $request->order_id)->first();

            // Check if transaction is found
            if($transaction){
                // Update the status to 'Paid'
                $transaction->update(['status_payment' => 'SUCCESS']);
            }
        }
    }
}


public function handle(Request $request)
    {
        $payload = $request->all();

        // Verifikasi signature
        $serverKey = config('midtrans.serverKey'); // Ganti dengan server key Midtrans Anda
        $orderId = $payload['order_id'];
        $amount = $payload['gross_amount'];
        $status = $payload['transaction_status'];
        $signatureKey = $payload['signature_key'];

        $mySignatureKey = hash('sha512', $orderId . $amount . $serverKey);

        if ($signatureKey !== $mySignatureKey) {
            return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 401);
        }

        // Proses notifikasi sesuai dengan status transaksi
        if ($status == 'capture') {
            // Transaksi berhasil ditangkap
            // Lakukan sesuatu di sini, contohnya:
            $this->processCapture($orderId);
        } elseif ($status == 'settlement') {
            // Transaksi berhasil ter-settlement
            // Lakukan sesuatu di sini, contohnya:
            $this->processSettlement($orderId);
        } elseif ($status == 'pending') {
            // Transaksi masih menunggu
            // Lakukan sesuatu di sini, contohnya:
            $this->processPending($orderId);
        } elseif ($status == 'deny' || $status == 'cancel' || $status == 'expire') {
            // Transaksi ditolak, dibatalkan, atau kadaluarsa
            // Lakukan sesuatu di sini, contohnya:
            $this->processDenyOrCancelOrExpire($orderId);
        }

        return response()->json(['status' => 'success']);
    }

    // Contoh fungsi untuk memproses transaksi yang berhasil ditangkap
    private function processCapture($orderId)
    {
        $order = Transaction::where('order_id', $orderId)->first();
        if ($order) {
            $order->update(['status' => 'success']);
        }
    }

    // Contoh fungsi untuk memproses transaksi yang berhasil ter-settlement
    private function processSettlement($orderId)
    {
        $order = Transaction::where('order_id', $orderId)->first();
        if ($order) {
            $order->update(['status' => 'settlement']);
        }
    }

    // Contoh fungsi untuk memproses transaksi yang masih pending
    private function processPending($orderId)
    {
        $order = Transaction::where('order_id', $orderId)->first();
        if ($order) {
            $order->update(['status' => 'pending']);
        }
    }

    // Contoh fungsi untuk memproses transaksi yang ditolak, dibatalkan, atau kadaluarsa
    private function processDenyOrCancelOrExpire($orderId)
    {
        $order = Transaction::where('order_id', $orderId)->first();
        if ($order) {
            $order->update(['status' => 'failed']);
        }
    }

}
