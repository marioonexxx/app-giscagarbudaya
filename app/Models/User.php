<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'peran',
        'kode_wilayah',
    ];



    // Relasi: User memiliki satu wilayah (khusus admin_kabupaten)
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'kode_wilayah', 'kode');
    }

    // Relasi: User (admin_kabupaten) bisa mendaftarkan banyak cagar budaya
    public function cagarBudaya()
    {
        return $this->hasMany(CagarBudaya::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
}
