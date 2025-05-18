<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Like;

class Post extends Model
{
    protected $primaryKey = 'post_id';

    protected $fillable = ['user_id', 'content', 'image'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'uid');
    }


    public function likes()
    {
        return $this->hasMany(Like::class, 'post_id', 'post_id');
    }

    public function isLikedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class, 'post_id');
    }

    
}
