<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenMouPGMI extends Model
{
    use HasFactory;

    protected $table = 'dokumen_mou_pgmi';

    protected $fillable = [
        'judul_dokumen',
        'nomor_mou',
        'tanggal_mou',
        'pihak_kerjasama',
        'file_dokumen',
        'keterangan',
    ];
}
