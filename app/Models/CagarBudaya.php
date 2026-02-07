<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CagarBudaya extends Model
{
    protected $table = 'cagar_budaya';

    // Mengizinkan semua field diisi kecuali ID
    protected $guarded = ['id'];

    protected $casts = [
        'koordinat' => 'array',
    ];

    // RELASI INI YANG HARUS ADA
    public function foto()
    {
        return $this->hasMany(FotoCagarBudaya::class, 'cagar_budaya_id');
    }
    // Tambahkan di dalam class CagarBudaya
    public function user()
    {
        // Ini mengasumsikan cagar budaya dibuat oleh user (Admin Kabupaten)
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriBudaya::class, 'kategori_id');
    }

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'kode_wilayah', 'kode');
    }
}
