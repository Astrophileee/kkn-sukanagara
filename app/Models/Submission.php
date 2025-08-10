<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $table = 'submissions';
    protected $fillable = [
        'status',
        'nama',
        'nik',
        'alamat',
        'pekerjaan',
        'rt',
        'status_desa',
        'jenis',
        'lokasi',
        'waktu',
        'kronologi',
        'pihak',
        'dampak',
        'harapan',
        'photo',
    ];
}
