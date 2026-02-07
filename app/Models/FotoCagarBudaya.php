<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoCagarBudaya extends Model
{

    protected $table = 'foto_cagar_budaya';

    protected $fillable = [
        'cagar_budaya_id',
        'path',
        'keterangan'
    ];

    public function cagar_budaya()
    {
        return $this->belongsTo(CagarBudaya::class, 'cagar_budaya_id');
    }
}
