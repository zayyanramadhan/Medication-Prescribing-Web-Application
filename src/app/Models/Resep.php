<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    protected $table = 'resep';
    protected $fillable = [
        'pemeriksaan_id',
        'obat_id',
        'obat_name',
        'obat_price',
        'jumlah',
        'total_price',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
}
