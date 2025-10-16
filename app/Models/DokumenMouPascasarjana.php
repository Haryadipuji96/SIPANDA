<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenMouPascasarjana extends Model
{
    use HasFactory;

    protected $table = 'dokumen_mou_pascasarjana';

    protected $fillable = [
        'judul_mou',
        'nomor_mou',
        'lembaga_mitra',
        'jenis_kerjasama',
        'tingkat_kerjasama',
        'tanggal_ttd',
        'masa_berlaku',
        'penanggung_jawab',
        'program_studi',
        'jenis_kegiatan',
        'file_dokumen',
        'keterangan',
    ];
}
