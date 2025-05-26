<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'peminjamans';
    protected $fillable = ['nama_peminjam', 'jumlah_peminjam', 'tgl_peminjam', 'tgl_kembali', 'status', 'barang_id', 'user_id'];

    public function barang()
    {
        return $this->belongsTo(barang::class, 'barang_id');
    }

    public function user()
    {
        return $this->belongsTo(user::class, 'user_id');
    }
}
