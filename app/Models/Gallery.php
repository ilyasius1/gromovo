<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_eng',
        'description',
        'main_image_id'
    ];

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function image(): HasOne
    {
        return $this->HasOne(Image::class, 'main_image_id');
    }
}
