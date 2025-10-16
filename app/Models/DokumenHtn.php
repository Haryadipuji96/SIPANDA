<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenHtn extends Model
{
    use HasFactory;

    protected $table = 'dokumen_htn'; // wajib biar ga salah ke 'dokumen_ekonomis'

    protected   $fillable = [
        'judul_mou',
        'lembaga_mitra',
        'nomor_mou',
        'kategori',
        'deskripsi',
        'file',
    ];
}
