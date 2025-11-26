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
        Schema::create('masakans', function (Blueprint $table) {
            $table->id('id_masakan');
            $table->string('nama_masakan', 100);
            $table->decimal('harga', 10, 2);
            $table->enum('status_masakan', ['tersedia', 'habis'])->default('tersedia');
            $table->string('foto')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('kategori', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masakans');
    }
};
