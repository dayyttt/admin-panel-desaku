<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wilayah extends Model
{
    protected $table = 'wilayah';

    protected $fillable = [
        'nama', 'tipe', 'kode', 'parent_id',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Wilayah::class, 'parent_id');
    }

    public function getFullPathAttribute(): string
    {
        $path = $this->nama;
        $parent = $this->parent;
        while ($parent) {
            $path = $parent->nama . ' → ' . $path;
            $parent = $parent->parent;
        }
        return $path;
    }
}
