<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{
    protected $table = 'markers'; // pastikan ini sesuai

    protected $primaryKey = 'marker_id'; // kalau kamu pakai custom primary key

    public function user()
    {
        return $this->belongsTo(User::class, 'uid');
        // uid adalah foreign key di tabel markers yang menunjuk ke id di tabel users
    }
}
