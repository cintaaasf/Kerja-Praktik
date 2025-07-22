<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    protected $fillable = [
        'nomor_berkas',
        'penerima',
        'tanggal',
        'perihal',
        'nomor_surat',
        'tanggal_terima',
        'file_surat',
        'user_id'
    ];
}