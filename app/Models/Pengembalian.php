<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'pengembalians';
    protected $fillable = ['jumlah_pengembalian', 'jumlah_barang_rusak','jumlah_barang_hilang', 'tanggal_pengembalian', 'status', 'peminjaman_id'];

    public function peminjaman()
    {
        return $this->belongsTo(peminjaman::class, 'peminjaman_id');
    }
}
