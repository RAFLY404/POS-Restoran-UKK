<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notif extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_type',
        'transaction_time',
        'transaction_status',
        'transaction_id',
        'status_message',
        'status_code',
        'signature_key',
        'settlement_time',
        'reference_id',
        'payment_type',
        'order_id',
        'merchant_id',
        'issuer',
        'gross_amount',
        'fraud_status',
        'expiry_time',
        'currency',
        'acquirer',
    ];
}
