<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kelompok extends Model
{
    use HasFactory;

    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'id');
    }
    public function dudi(): BelongsTo
    {
        return $this->belongsTo(Dudi::class);
    }
    public function kakomli(): BelongsTo
    {
        return $this->belongsTo(Kakomli::class);
    }
}
