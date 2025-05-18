<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';
    protected $fillable = ['post_id', 'user_id'];
    public $timestamps = true;
    public $incrementing = false;
    protected $primaryKey = 'like_id';


    public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'uid');
}
}
