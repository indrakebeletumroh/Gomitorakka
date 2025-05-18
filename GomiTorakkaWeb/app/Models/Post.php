<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\users;

class Post extends Model
{
      protected $table = 'posts';
    protected $primaryKey = 'post_id';
    public $incrementing = true;  // ini penting kalau post_id auto-increment integer
    protected $fillable = ['user_id', 'content', 'image'];


    public function user()
    {
        return $this->belongsTo(users::class, 'user_id', 'uid');
    }
}

