<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Period extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start',
        'end',
        'is_holiday',
        'is_active'
    ];

    // Scopes
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active');
    }

    // Relations

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class);
    }
}
