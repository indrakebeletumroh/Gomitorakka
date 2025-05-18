<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['user_id', 'post_id'];

    public function user()
    {
        return $this->belongsTo(users::class, 'user_id', 'uid');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
     protected static function booted()
    {
        static::created(function ($like) {
            $like->post->incrementLikes();
        });

        static::deleted(function ($like) {
            $like->post->decrementLikes();
        });
    }
}