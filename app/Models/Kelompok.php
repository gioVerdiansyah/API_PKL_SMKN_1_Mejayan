<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Kelompok extends Model
{
    use HasFactory;

    public $incrementing = false, $keyType = "string";
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
    public function dudi(): BelongsTo
    {
        return $this->belongsTo(Dudi::class);
    }
    public function kakomli(): BelongsTo
    {
        return $this->belongsTo(Kakomli::class);
    }

    public function anggota(): HasMany
    {
        return $this->hasMany(AnggotaKelompok::class, 'kelompok_id');
    }
}
