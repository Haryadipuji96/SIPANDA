<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenSt extends Model
{
    use HasFactory;

    protected $table = 'dokumen_st';

    protected $fillable = [
        'judul',
        'nomor_st',
        'tanggal_st',
        'pemberi_tugas',
        'nama_petugas',
        'tugas',
        'file_dokumen',
        'keterangan',
    ];
}
