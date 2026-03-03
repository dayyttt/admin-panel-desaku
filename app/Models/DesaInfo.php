<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesaInfo extends Model
{
    protected $table = 'desa_info';
    
    protected $fillable = [
        'key',
        'data',
        'aktif',
    ];

    protected $casts = [
        'data' => 'array',
        'aktif' => 'boolean',
    ];
}
