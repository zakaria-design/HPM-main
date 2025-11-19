<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Izin extends Model
{
     use HasFactory;

     protected $table = 'izin';
    protected $fillable = [
        'user_id',
        'alasan_izin',
        'foto_bukti',
        'waktu',
        'jam',
    ];

    
    protected $casts = [
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
