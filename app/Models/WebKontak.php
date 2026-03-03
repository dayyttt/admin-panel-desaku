<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebKontak extends Model
{
    protected $fillable = [
        'nama',
        'email',
        'subjek',
        'pesan',
        'status',
        'catatan',
        'dibaca_pada',
    ];

    protected $casts = [
        'dibaca_pada' => 'datetime',
    ];
}
