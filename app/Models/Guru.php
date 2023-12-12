<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Guru extends Model implements Authenticatable
{
    use AuthenticableTrait;
    use HasFactory;

    protected $guarded=[], $hidden = [
        'password'
    ],$cast = [
        'password' => 'hashed'
    ];

    public function jurusan():BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
}
