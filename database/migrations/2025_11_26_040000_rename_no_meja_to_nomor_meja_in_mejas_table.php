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
        Schema::table('mejas', function (Blueprint $table) {
            $table->renameColumn('no_meja', 'nomor_meja');
        });

        // Also update the foreign key in orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['no_meja']);
            $table->renameColumn('no_meja', 'nomor_meja');
            $table->foreign('nomor_meja')->references('nomor_meja')->on('mejas')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['nomor_meja']);
            $table->renameColumn('nomor_meja', 'no_meja');
            $table->foreign('no_meja')->references('no_meja')->on('mejas')->onDelete('restrict');
        });

        Schema::table('mejas', function (Blueprint $table) {
            $table->renameColumn('nomor_meja', 'no_meja');
        });
    }
};
