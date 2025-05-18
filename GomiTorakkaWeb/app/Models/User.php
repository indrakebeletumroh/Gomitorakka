<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'uid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uid',
        'username',
        'age',
        'phone_number',
        'email',
        'password',
        'profile_picture',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function markers()
    {
        return $this->hasMany(Marker::class, 'uid', 'uid');
    }
}
