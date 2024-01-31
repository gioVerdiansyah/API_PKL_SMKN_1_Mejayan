<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Jurusan extends Model
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
    public $timestamps = false;
    public function kakomli():HasOne{
        return $this->hasOne(Kakomli::class, 'id');
    }
    public function dudi():HasOne{
        return $this->hasOne(Dudi::class, 'id');
    }
}
