<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'historys';
    protected $fillable = ['jenis_kegiatan', 'tanggal_kegiatan', 'status', 'barang_id'];

    public function barang()
    {
        return $this->belongsTo(barang::class, 'barang_id');
    }
}
