<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Kakomli extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [], $hidden = [
        'password'
    ], $cast = [
        'password' => 'hashed'
    ];

    public function jurusan(): BelongsTo{
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
}
