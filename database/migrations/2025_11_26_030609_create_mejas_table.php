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
        Schema::create('mejas', function (Blueprint $table) {
            $table->id('id_meja');
            $table->string('no_meja', 10)->unique();
            $table->enum('status_meja', ['kosong', 'terisi', 'dipesan'])->default('kosong');
            $table->integer('kapasitas')->default(4);
            $table->string('lokasi', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mejas');
    }
};
