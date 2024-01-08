<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DetailUser extends Model
{
    public $timestamps = false;
    use HasFactory;
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function detailPkl():HasOne{
        return $this->hasOne(DetailPkl::class);
    }
    public function jurusan():BelongsTo{
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
    public function kelas():BelongsTo{
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
