<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class BarangRusak extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'barangRusaks';
    protected $fillable = ['pengembalian_id'];

    public function pengembalian()
    {
        return $this->belongsTo(pengembalian::class, 'pengembalian_id');
    }

}
