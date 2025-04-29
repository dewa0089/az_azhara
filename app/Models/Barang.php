<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'barangs';
    protected $fillable = ['kode_barang', 'nama_barang', 'jumlah_barang', 'harga_barang', 'gambar_barang', 'tanggal_beli_barang', 'keterangan'];

}
