<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresSph extends Model
{
    protected $table = 'progres_sph';
    protected $fillable = [
        'nomor_surat',
        'nama_customer',
        'nominal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id'); 
        // 'user_id' di sph -> 'user_id' di users
    }
}
