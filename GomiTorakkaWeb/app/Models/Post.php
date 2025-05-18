<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\users;

class Post extends Model
{
      protected $table = 'posts';
    protected $primaryKey = 'post_id';
    public $incrementing = true;  // ini penting kalau post_id auto-increment integer
    protected $fillable = ['user_id', 'content', 'image', 'likes_count'];


    public function user()
    {
        return $this->belongsTo(users::class, 'user_id', 'uid');
    }
    
    public function likes()
    {
        return $this->hasMany(Like::class, 'post_id', 'post_id');
    }
      public function incrementLikes()
    {
        $this->timestamps = false; // Prevent updating updated_at
        $this->increment('likes_count');
        $this->timestamps = true;
    }

    public function decrementLikes()
    {
        $this->timestamps = false;
        $this->decrement('likes_count');
        $this->timestamps = true;
    }
}

