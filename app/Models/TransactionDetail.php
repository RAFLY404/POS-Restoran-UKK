<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

     protected $fillable = [
        'transaction_id', 'item_id', 'price', 'quantity'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id','id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'item_id','id');
    }
}
