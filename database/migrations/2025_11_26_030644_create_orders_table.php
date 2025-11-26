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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('id_order');
            $table->string('no_meja', 10);
            $table->date('tanggal');
            $table->unsignedBigInteger('id_user');
            $table->text('keterangan')->nullable();
            $table->enum('status_order', ['menunggu', 'diproses', 'selesai', 'dibayar'])->default('menunggu');
            $table->decimal('total_harga', 10, 2)->default(0);
            $table->timestamps();
            
            $table->foreign('id_user')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('no_meja')->references('no_meja')->on('mejas')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
