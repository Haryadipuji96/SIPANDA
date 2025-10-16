<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSarpras extends Model
{
    use HasFactory;

    protected $table = 'data_sarpras';

    protected $fillable = [
        'nama_barang',
        'kategori',
        'lokasi',
        'jumlah',
        'kondisi',
        'tanggal_pengadaan',
        'keterangan',
        'file_dokumen',
    ];
}
