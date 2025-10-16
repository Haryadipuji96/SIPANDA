<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenEkonomi extends Model
{
    use HasFactory;

    protected $table = 'dokumen_ekonomi'; // wajib biar ga salah ke 'dokumen_ekonomis'

    protected $fillable = [
        'judul',
        'kategori',
        'deskripsi',
        'file',
    ];
}


