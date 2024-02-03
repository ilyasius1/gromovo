<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cottage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cottage_type_id',
        'gallery_id',
        'schema_gallery_id',
        'summer_gallery_id',
        'winter_gallery_id',
        'description',
        'area',
        'floors',
        'bedrooms',
        'single_beds',
        'double_beds',
        'additional_single_beds',
        'additional_double_beds',
        'bathrooms',
        'showers',
        'sauna',
        'fireplace',
        'floor1_features',
        'floor2_features',
        'floor3_features',
        'is_active'
    ];

    protected $casts = [
        'floor1_features' => 'array',
        'floor2_features' => 'array',
        'floor3_features' => 'array',
    ];

    // Relations
    public function cottageType(): BelongsTo
    {
        return $this->belongsTo(CottageType::class);
    }


    public function gallery(): BelongsTo
    {
        return $this->BelongsTo(Gallery::class);
    }

    public function schemaGallery(): BelongsTo
    {
        return $this->BelongsTo(Gallery::class, 'schema_gallery_id');
    }

    public function summerGallery(): BelongsTo
    {
        return $this->BelongsTo(Gallery::class, 'summer_gallery_id');
    }

    public function winterGallery(): BelongsTo
    {
        return $this->BelongsTo(Gallery::class, 'winter_gallery_id');
    }
}
