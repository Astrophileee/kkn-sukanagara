<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Comment extends Model
{
    protected $fillable = [
        'isi',
        'photo',
        'id_user',
        'id_forum',
        'photo'
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
    public function forum()
    {
        return $this->belongsTo(Forum::class, 'id_forum');
    }
}
