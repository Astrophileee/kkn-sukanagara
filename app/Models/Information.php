<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Information extends Model
{
    protected $table = 'informations';
        protected $fillable = [
        'judul',
        'isi',
        'photo'
    ];


    protected function photoUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (filter_var($this->photo, FILTER_VALIDATE_URL)) {
                    return $this->photo;
                }

                if ($this->photo) {
                    return url(Storage::url($this->photo));
                }

                $avatar = '/images/default-image-square.jpg';

                return url($avatar);
            }
        );
    }

    protected function thumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (filter_var($this->photo, FILTER_VALIDATE_URL)) {
                    return $this->photo;
                }

                if ($this->photo) {
                    $thumbnail = dirname($this->photo) . '/' . basename($this->photo);

                    return url(Storage::url($thumbnail));
                }

                $avatar = '/images/default-image-square.jpg';

                return url($avatar);
            }
        );
    }
}
