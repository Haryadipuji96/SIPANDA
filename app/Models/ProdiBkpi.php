<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdiBkpi extends Model
{
    use HasFactory;

    protected $table = 'prodi_bkpi';

    protected $fillable = [
        'judul_mou',
        'mitra_kerjasama',
        'nomor_dokumen',
        'tanggal_mulai',
        'tanggal_berakhir',
        'bidang_kerjasama',
        'deskripsi',
        'file',
    ];
}
