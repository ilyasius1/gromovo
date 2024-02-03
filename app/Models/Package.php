<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nights',
        'days_start',
        'days_end'
    ];

    // Relations

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class);
    }
}
