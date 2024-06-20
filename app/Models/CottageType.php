<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Screen\AsSource;

/**
 * @property int id
 * @property string name
 * @property int main_places
 * @property int additional_places
 * @property int children_places
 * @property string created_at
 * @property string updated_at
 *
 * @method static Builder|Cottage query()
 * @method static CottageType create()
 */
class CottageType extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;


    protected $fillable = [
        'name',
        'main_places',
        'additional_places',
        'children_places'
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

    /**
     * @return HasMany
     */
    public function cottages(): HasMany
    {
        return $this->hasMany(Cottage::class);
    }

    /**
     * @return HasMany
     */
    public function prices(): HasMany
    {
        return $this->hasMany(Price::class);
    }
}
