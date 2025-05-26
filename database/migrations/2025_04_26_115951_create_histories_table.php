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
        Schema::create('histories', function (Blueprint $table) {
        $table->id();
        $table->string('jenis_kegiatan');
        $table->date('tanggal_kegiatan');
        $table->time('waktu_kegiatan');
        $table->string('status');
        $table->morphs('item'); // ini membuat kolom item_id dan item_type
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historys');
    }
};
