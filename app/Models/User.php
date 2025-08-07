<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'jabatan',
        'status',
        'media',
        'riwayat_berita',
        'photo'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

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

                $avatar = '/images/avatar.jpg';

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

                $avatar = '/images/avatar.jpg';

                return url($avatar);
            }
        );
    }

        public function forums()
    {
        return $this->hasMany(Forum::class);
    }
        public function comments()
    {
        return $this->hasMany(Comment::class);
    }


}

