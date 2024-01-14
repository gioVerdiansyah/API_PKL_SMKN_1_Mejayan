<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Jurusan extends Model
{
    use HasFactory;

    public $timestamps = false;
    public function kakomli():HasOne{
        return $this->hasOne(Kakomli::class, 'id');
    }
    public function dudi():HasOne{
        return $this->hasOne(Dudi::class, 'id');
    }
}
