<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CottageType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function cottages(): HasMany
    {
        return $this->hasMany(Cottage::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class);
    }
}
