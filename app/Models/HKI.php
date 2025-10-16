<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HKI extends Model
{
    use HasFactory;

    protected $table = 'hki'; 

    protected $fillable = [
        'nama_dokumen_kegiatan',
        'tahun',
        'fakultas',
        'deskripsi',
        'file',
    ];
}
