<?php

namespace App\Models;

use App\Models\TransactionDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';

    protected $fillable = [
        'id','order_id', 'user_id', 'nama_pelanggan', 'tanggal_transaksi', 'gross_amount', 'payment_method', 'status_transaction', 'status_payment', 'nomor meja'
    ];


    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id','id');
    }
}
