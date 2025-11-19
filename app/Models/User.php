<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'user_id',
        'email',
        'password',
        'alamat',
        'no_hp',
        'foto',
        'role',
    ];
        protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke tabel Hadir
    public function hadir()
{
    return $this->hasMany(\App\Models\Hadir::class, 'user_id');
}


    // Relasi ke tabel Izin
    public function izin()
    {
        return $this->hasMany(Izin::class, 'user_id', 'id');
    }

    // Relasi ke tabel Sakit
    public function sakit()
    {
        return $this->hasMany(Sakit::class, 'user_id','id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function absens()
    {
        return $this->hasMany(Absen::class, 'user_id');
    }

}
