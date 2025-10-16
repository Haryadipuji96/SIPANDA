<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenDosen extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'dokumen_dosens';

    // Kolom yang boleh diisi mass assignment
    protected $fillable = [
        'dosen_id',
        'kategori_id',
        'nama_dokumen',
        'file_path',
        'tanggal_upload',
        'keterangan',
    ];

    // Relasi ke model Dosen
    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    // Relasi ke model KategoriDokumen
    public function kategori()
    {
        return $this->belongsTo(KategoriDokumen::class, 'kategori_id');
    }
}
