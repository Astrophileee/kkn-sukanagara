<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apbn extends Model
{
    /** @use HasFactory<\Database\Factories\ApbnFactory> */
    use HasFactory;

    protected $table = 'apbns';
    protected $fillable = ['label','total'];
}
