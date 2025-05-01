<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{
    use HasFactory;

    protected $table = 'markers';
    protected $primaryKey = 'marker_id';

    protected $fillable = [
        'user_id', 'description', 'latitude', 'longitude', 'status'
    ];
}

