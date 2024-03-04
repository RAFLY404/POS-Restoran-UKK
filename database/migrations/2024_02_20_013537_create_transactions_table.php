<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
             
            $table->id();
            $table->string('order_id');$table->unsignedBigInteger('user_id')->nullable(); // Kolom user_id dijadikan nullable
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->date('tanggal_transaksi')->default(DB::raw('CURRENT_TIMESTAMP')); 
            $table->decimal('gross_amount', 10, 3);
            $table->enum( 'payment_method', ['CASH','CASHLESS']);
            $table->enum( 'status', ['PENDING','SUCCESS','FAILED'])->default('PENDING');
            // Tambahkan kolom lain sesuai kebutuhan transaksi Anda
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
