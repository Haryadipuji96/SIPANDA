<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakultasSyariah extends Model
{
    use HasFactory;

    protected $table = 'fakultas_syariahs';

    protected $fillable = [
        'nama_fakultas',
        'dekan',
        'deskripsi',
        'file',
    ];
}
