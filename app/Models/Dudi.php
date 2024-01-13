<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Schema;

class Dudi extends Model
{
    use HasFactory, SerializesModels;

    protected $guarded = [];
    public function user(): HasOne{
        return $this->hasOne(User::class, 'id');
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
}
