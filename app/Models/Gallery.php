<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Screen\AsSource;

/**
 * @property int id
 * @property string name
 * @property string name_eng
 * @property string description
 * @property string main_image_id
 *
 * @method static Builder|Cottage query()
 * @method static Gallery create(array $fields)
 */
class Gallery extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $fillable = [
        'name',
        'name_eng',
        'description',
        'main_image_id'
    ];

    //Orchid filters and sorts
    protected array $allowedFilters = [
        'id' => Where::class,
        'name' => Where::class,
        'created_at' => WhereDateStartEnd::class,
        'updated_at' => WhereDateStartEnd::class
    ];

    protected array $allowedSorts = [
        'id',
        'name',
        'created_at',
        'updated_at'
    ];

    //Relations

    /**
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Main image
     *
     * @return HasOne
     */
    public function image(): HasOne
    {
        return $this->HasOne(Image::class, 'main_image_id');
    }
}
