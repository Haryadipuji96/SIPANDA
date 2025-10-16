<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTendik extends Model
{
    use HasFactory;

    protected $table = 'data_tendik';

    protected $fillable = [
        'nama_tendik',
        'nip',
        'jabatan',
        'status_kepegawaian',
        'pendidikan_terakhir',
        'jenis_kelamin',
        'no_hp',
        'email',
        'alamat',
        'keterangan',
        'foto',
    ];
}
