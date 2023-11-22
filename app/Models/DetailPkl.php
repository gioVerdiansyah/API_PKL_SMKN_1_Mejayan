<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DetailPkl extends Model
{
    public $timestamps = false;
    use HasFactory;
    public function detailUser():BelongsTo{
        return $this->belongsTo(DetailUser::class);
    }
    public function jamPkl():HasOne{
        return $this->hasOne(JamPkl::class);
    }
}
