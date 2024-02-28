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
use Orchid\Filters\Types\WhereIn;
use Orchid\Screen\AsSource;

/**
 * @property int id
 * @property string name
 * @property int nights
 * @property string days_start
 * @property string days_end
 * @property string created_at
 * @property string updated_at
 *
 * @method static Builder|Package query()
 * @method static Package create()
 * @method static Builder|Package filters()
 * @method static Builder|Package defaultSort(string $column, string $direction = 'asc')
 */
class Package extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $fillable = [
        'name',
        'nights',
        'days_start',
        'days_end',
    ];

    //Orchid filters and sorts
    protected array $allowedFilters = [
        'id' => Where::class,
        'name' => Where::class,
        'nights' => Where::class,
        'days_start' => WhereIn::class,
        'days_end' => WhereIn::class,
        'created_at' => WhereDateStartEnd::class,
        'updated_at' => WhereDateStartEnd::class
    ];

    protected array $allowedSorts = [
        'id',
        'name',
        'nights',
        'days_start',
        'days_end',
        'created_at',
        'updated_at'
    ];

    // Relations

    /**
     * @return HasMany
     */
    public function prices(): HasMany
    {
        return $this->hasMany(Price::class);
    }
}
