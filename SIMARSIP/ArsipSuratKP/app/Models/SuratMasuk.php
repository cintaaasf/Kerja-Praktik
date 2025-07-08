<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $fillable = [
        'nomor_berkas',
        'pengirim',
        'tanggal',
        'nomor',
        'perihal',
        'ditujukan_kepada',
        'file_surat',
        'user_id'
    ];
}