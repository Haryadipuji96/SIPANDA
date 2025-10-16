<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

     protected $table = 'dosens'; 

    protected $fillable = [
        'nip', 'nama', 'jabatan', 'pendidikan_terakhir',
        'status_kepegawaian', 'jenis_kelamin', 'keterangan'
    ];

    public function dokumens()
    {
        return $this->hasMany(DokumenDosen::class);
    }
}
