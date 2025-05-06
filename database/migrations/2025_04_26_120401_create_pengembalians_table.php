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
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('jumlah_pengembalian')->nullable();
            $table->integer('jumlah_barang_rusak')->nullable();
            $table->integer('jumlah_barang_hilang')->nullable();
            $table->date('tanggal_pengembalian')->nullable();
            $table->uuid('peminjaman_id');
            $table->foreign('peminjaman_id')->references('id')->on('peminjamans')->restrictOnDelete()->restrictOnUpdate();
            $table->string('status')->default('Dipijam')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
