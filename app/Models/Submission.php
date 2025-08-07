<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $table = 'submissions';
    protected $fillable = [
        'judul',
        'isi',
        'status',
        'nama_pengaju',
        'nomor_hp_pengaju',
        'id_user'
    ];

        public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
        public function forums()
    {
        return $this->hasMany(Forum::class, 'id_forum');
    }
}
