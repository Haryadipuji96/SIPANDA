<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPeraturan extends Model
{
    use HasFactory;

    protected $table = 'dokumen_peraturan';

    protected $fillable = [
        'judul',
        'nomor_peraturan',
        'kategori',
        'tanggal_terbit',
        'file_dokumen',
        'keterangan',
    ];
}
