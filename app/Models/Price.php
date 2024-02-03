<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cottage_type_id',
        'period_id',
        'package_id',
        'rate',
        'is_active'
    ];

    // Scopes
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active');
    }

    // Relations
    public function cottageType(): BelongsTo
    {
        return $this->belongsTo(CottageType::class, 'cottage_type_id');
    }

    public function period():BelongsTo
    {
        return $this->belongsTo(Period::class, 'period_id');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

}
