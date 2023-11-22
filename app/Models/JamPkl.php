<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JamPkl extends Model
{
    public $timestamps = false;
    use HasFactory;
    public function detailPkl():BelongsTo{
        return $this->belongsTo(JamPkl::class,);
    }
}
