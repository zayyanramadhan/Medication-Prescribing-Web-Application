<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    protected $table = 'pemeriksaan';
    protected $fillable = [
        'dokter_id',
        'apoteker_id',
        'pasien_id',
        'tinggi_badan',
        'berat_badan',
        'systole',
        'diastole',
        'heart_rate',
        'respiration_rate',
        'suhu_tubuh',
        'pemeriksaan_dokter',
        'berkas',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
}
