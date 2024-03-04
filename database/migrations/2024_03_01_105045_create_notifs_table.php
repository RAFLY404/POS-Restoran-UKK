<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifs', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_type');
            $table->dateTime('transaction_time');
            $table->string('transaction_status');
            $table->string('transaction_id');
            $table->string('status_message');
            $table->string('status_code');
            $table->string('signature_key');
            $table->dateTime('settlement_time');
            $table->string('reference_id');
            $table->string('payment_type');
            $table->string('order_id');
            $table->string('merchant_id');
            $table->string('issuer');
            $table->decimal('gross_amount', 10, 2);
            $table->string('fraud_status');
            $table->dateTime('expiry_time');
            $table->string('currency');
            $table->string('acquirer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifs');
    }
};
