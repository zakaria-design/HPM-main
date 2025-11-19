<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skt extends Model
{
    protected $table = 'skt';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id'); 
        // 'user_id' di sph -> 'user_id' di users
    }
}
