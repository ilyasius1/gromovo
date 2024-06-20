<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Filters\Types\WhereIn;
use Orchid\Screen\AsSource;

/**
 * @property int id
 * @property string name
 * @property int cottage_type_id
 * @property int main_gallery_id
 * @property int schema_gallery_id
 * @property int summer_gallery_id
 * @property int winter_gallery_id
 * @property string description
 * @property int area
 * @property int floors
 * @property int bedrooms
 * @property int single_beds
 * @property int double_beds
 * @property int additional_single_beds
 * @property int additional_double_beds
 * @property int bathrooms
 * @property int showers
 * @property bool sauna
 * @property bool fireplace
 * @property string floor1_features
 * @property string floor2_features
 * @property string floor3_features
 * @property string is_active
 * @property string created_at
 * @property string updated_at
 *
 * @method static Builder|Cottage query()
 * @method static Cottage create()
 * @method Builder|Cottage active()
 * @method static Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|Cottage findOrFail($id, $columns = ['*'])
 * @method static Builder|Cottage filters()
 * @method static Builder|Cottage defaultSort(string $column, string $direction = 'asc')
 */
class Cottage extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $fillable = [
        'name',
        'cottage_type_id',
        'main_gallery_id',
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

    //Casts and mutators
    protected $casts = [
        'floor1_features' => 'array',
        'floor2_features' => 'array',
        'floor3_features' => 'array',
    ];

    //Orchid filters and sorts
    protected array $allowedFilters = [
        'id' => Where::class,
        'name' => Like::class,
        'cottage_type_id' => WhereIn::class,
        'is_active' => Where::class,
        'created_at' => WhereDateStartEnd::class,
        'updated_at' => WhereDateStartEnd::class
    ];

    protected array $allowedSorts = [
        'id',
        'name',
        'cottage_type_id',
        'created_at',
        'updated_at',
    ];

    //Scopes

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    // Relations

    /**
     * @return BelongsTo
     */
    public function cottageType(): BelongsTo
    {
        return $this->belongsTo(CottageType::class);
    }


    /**
     * @return BelongsTo
     */
    public function mainGallery(): BelongsTo
    {
        return $this->BelongsTo(Gallery::class);
    }

    /**
     * @return BelongsTo
     */
    public function schemaGallery(): BelongsTo
    {
        return $this->BelongsTo(Gallery::class, 'schema_gallery_id');
    }

    /**
     * @return BelongsTo
     */
    public function summerGallery(): BelongsTo
    {
        return $this->BelongsTo(Gallery::class, 'summer_gallery_id');
    }

    /**
     * @return BelongsTo
     */
    public function winterGallery(): BelongsTo
    {
        return $this->BelongsTo(Gallery::class, 'winter_gallery_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'cottage_id');
    }
}
