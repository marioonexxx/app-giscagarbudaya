<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBudaya extends Model
{
    use HasFactory;

    // 1. Beritahu Laravel nama tabel yang benar di database
    protected $table = 'kategori_budaya';

    // 2. Beritahu kolom mana saja yang boleh diisi (mass assignment)
    protected $fillable = [
        'nama_kategori',
        'deskripsi_kategori' // sesuaikan dengan kolom di migrasi kategori kamu
    ];

    /**
     * Relasi ke Cagar Budaya (Satu kategori punya banyak objek)
     */
    public function cagarBudaya()
    {
        return $this->hasMany(CagarBudaya::class, 'kategori_id');
    }
}
