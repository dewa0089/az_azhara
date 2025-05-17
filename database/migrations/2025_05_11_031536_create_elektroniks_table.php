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
        Schema::create('elektroniks', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->string('merk');
            $table->string('type');
            $table->date('tgl_peroleh')->nullable();
            $table->string('asal_usul');
            $table->string('cara_peroleh')->nullable();
            $table->integer('jumlah_brg')->nullable();
            $table->integer('harga_perunit')->nullable();
            $table->integer('total_harga')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elektroniks');
    }
};
