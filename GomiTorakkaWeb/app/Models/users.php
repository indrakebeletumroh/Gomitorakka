<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class users extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'uid'; // Match your database primary key
    public $incrementing = false; // Set to false if uid is not auto-incrementing
    protected $keyType = 'string'; // Set to 'string' if uid is not integer

    protected $fillable = [
        'uid',
        'username',
        'age',
        'phone_number',
        'email',
        'password',
        'profile_picture'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}