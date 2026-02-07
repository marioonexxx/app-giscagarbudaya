<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    // Kasih tahu Laravel kalau nama tabelnya 'wilayah', bukan 'wilayahs'
    protected $table = 'wilayah';

    // Karena primary key-nya 'kode' (bukan id), tambahkan ini:
    protected $primaryKey = 'kode';

    // Kalau kodenya bukan auto-increment (string 81.71), tambahkan ini:
    public $incrementing = false;
    protected $keyType = 'string';
}
