<?php

namespace App\Models;

use App\Notifications\ResetPasswordGuruNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class Guru extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $incrementing = false, $keyType = "string";
    protected $rememberTokenName = 'remember_token';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }

    /**
     * Get all the column names from the model's table.
     *
     * @return array
     */
    public function getTableColumns()
    {
        return Schema::getColumnListing($this->getTable());
    }

    protected $guarded = [], $hidden = [
        'password'
    ], $cast = [
        'password' => 'hashed'
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordGuruNotification($token, $this->email));
    }
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function kelompok(): HasMany
    {
        return $this->hasMany(Kelompok::class, 'guru_id');
    }

    public function absensi()
    {
        return $this->hasManyThrough(Absensi::class, Kelompok::class, 'guru_id', 'kelompok_id', 'id', 'id');
    }
}
