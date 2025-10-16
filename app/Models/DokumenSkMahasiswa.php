<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenSkMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'dokumen_sk_mahasiswa'; 

    protected $fillable = [
        'judul',
        'nomor_sk',
        'tanggal_sk',
        'file_dokumen',
        'keterangan',
    ];
}
