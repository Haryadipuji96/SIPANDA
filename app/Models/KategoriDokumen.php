<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriDokumen extends Model
{
    use HasFactory;

    protected $table = 'kategori_dokumens';

    protected $fillable = ['nama_kategori', 'deskripsi'];

    public function dokumens()
    {
        return $this->hasMany(DokumenDosen::class, 'kategori_id');
    }
}
