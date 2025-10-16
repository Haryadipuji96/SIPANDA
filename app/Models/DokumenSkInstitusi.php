<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenSkInstitusi extends Model
{
    use HasFactory;

    protected $table = 'dokumen_sk_institusi'; 

    protected $fillable = [
        'judul',
        'nomor_sk',
        'tanggal_sk',
        'unit_penerbit',
        'kategori',
        'file_dokumen',
        'keterangan',
    ];
}
