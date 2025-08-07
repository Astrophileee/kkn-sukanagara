<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Forum extends Model
{
    protected $fillable = [
        'judul',
        'isi',
        'photo',
        'id_user',
        'id_submission'
    ];
        protected function photoUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => url($this->photo ? Storage::url($this->photo) : '/images/default-image-square.png'),
        );
    }
        public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_forum');
    }
        public function submission()
    {
        return $this->belongsTo(Submission::class, 'id_submission');
    }

}
