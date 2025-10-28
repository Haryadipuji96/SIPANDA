<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosens';

    protected $fillable = [
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'nik',
        'pendidikan_terakhir',
        'jabatan',
        'tmt_kerja',
        'masa_kerja_tahun',
        'masa_kerja_bulan',
        'golongan',
        'masa_kerja_golongan_tahun',
        'masa_kerja_golongan_bulan',
        'file_dokumen',
    ];

    public function dokumens()
    {
        return $this->hasMany(DokumenDosen::class);
    }

    // Accessor tambahan (opsional) untuk menampilkan masa kerja gabungan
    public function getMasaKerjaAttribute()
    {
        return "{$this->masa_kerja_tahun} Thn {$this->masa_kerja_bulan} Bln";
    }

    public function getMasaKerjaGolonganAttribute()
    {
        return "{$this->masa_kerja_golongan_tahun} Thn {$this->masa_kerja_golongan_bulan} Bln";
    }
}
