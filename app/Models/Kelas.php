<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function detailUser(): HasMany{
        return $this->hasMany(DetailUser::class, 'id');
    }
}