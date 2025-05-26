<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_kegiatan', 
        'tanggal_kegiatan', 
        'waktu_kegiatan', 
        'status', 
        'item_id', 
        'item_type'
    ];

    public function item()
    {
        return $this->morphTo();
    }
}
