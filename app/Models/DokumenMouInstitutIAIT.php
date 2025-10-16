<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenMouInstitutIAIT extends Model
{
    use HasFactory;

    protected $table = 'dokumen_mou_institut_iait';

    protected $fillable = [
        'judul_mou',
        'nomor_mou',
        'lembaga_mitra',
        'jenis_kerjasama',
        'tingkat_kerjasama',
        'tanggal_ttd',
        'masa_berlaku',
        'penanggung_jawab',
        'file_dokumen',
        'keterangan',
    ];
}
