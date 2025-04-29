<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Pemusnaan extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'pemusnaans';
    protected $fillable = ['jumlah_pemusnaan', 'tanggal_pemusnaan', 'keterangan', 'status', 'barang_rusak_id'];

    public function barang_rusak()
    {
        return $this->belongsTo(barang_rusak::class, 'barang_rusak_id');
    }
}
