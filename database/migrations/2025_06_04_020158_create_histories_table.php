<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');  // siapa yang melakukan aksi
        $table->string('action');               // aktivitas yang dilakukan, misal 'Tambah Barang'
        $table->text('description')->nullable();  // deskripsi tambahan (optional)
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
