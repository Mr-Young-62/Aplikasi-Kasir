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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_order');
            $table->date('tanggal');
            $table->decimal('total_bayar', 10, 2);
            $table->decimal('uang_bayar', 10, 2);
            $table->decimal('kembalian', 10, 2);
            $table->enum('metode_pembayaran', ['cash', 'transfer', 'kartu', 'ewallet'])->default('cash');
            $table->string('no_referensi', 100)->nullable();
            $table->enum('status_transaksi', ['berhasil', 'batal', 'pending'])->default('berhasil');
            $table->timestamps();
            
            $table->foreign('id_user')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('id_order')->references('id_order')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
