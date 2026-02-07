<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluasiCagarBudaya extends Model
{
    use HasFactory;

    protected $table = 'evaluasi_cagar_budaya';

    // Semua field boleh diisi secara mass-assignment kecuali ID
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_evaluasi' => 'datetime',
    ];

    /**
     * Relasi ke Data Cagar Budaya
     */
    public function cagarBudaya(): BelongsTo
    {
        return $this->belongsTo(CagarBudaya::class, 'cagar_budaya_id');
    }

    /**
     * Relasi ke User (Evaluator)
     */
    public function evaluator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }
}
