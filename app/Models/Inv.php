<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inv extends Model
{
    protected $table = 'inv';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id'); 
        // 'user_id' di sph -> 'user_id' di users
    }
}
