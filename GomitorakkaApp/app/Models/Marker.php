<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{
    protected $table = 'markers';
    public $timestamps = false;

    protected $fillable = [
        'lat', 'lng', 'jenis'
    ];
}

