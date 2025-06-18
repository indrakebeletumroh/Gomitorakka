<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    protected $table = 'inboxes';

    protected $fillable = [
        'user_id',
        'marker_id',
        'title',
        'message',
        'status',
    ];

    /**
     * Optional: Scope to filter unread messages
     */
    public function scopeUnread($query)
    {
        return $query->where('status', 'unread');
    }

    /**
     * Optional: Scope to filter read messages
     */
    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }
}
