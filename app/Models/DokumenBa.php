<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenBa extends Model
{
    use HasFactory;

    protected $table = 'dokumen_ba';

    protected $fillable = [
        'judul',
        'nomor_ba',
        'tanggal_ba',
        'tempat',
        'pihak_terlibat',
        'keterangan',
        'file_dokumen',
    ];
}
