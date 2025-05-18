<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    protected $table = 'post_comments';
    protected $primaryKey = 'comment_id';

    protected $fillable = [
        'post_id',
        'uid',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'uid');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
