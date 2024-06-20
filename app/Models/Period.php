<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Screen\AsSource;

/**
 * @property int id
 * @property string name
 * @property string start
 * @property string end
 * @property bool is_holiday
 * @property bool is_active
 * @property string nameWithDates
 * @property string created_at
 * @property string updated_at
 *
 * @method static Builder|Period query()
 * @method static Period create(array $fields)
 * @method Builder|Period active()
 * @method static Builder|Period filters()
 * @method static Builder defaultSort(string $column, string $direction = 'asc')
 */
class Period extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $fillable = [
        'name',
        'start',
        'end',
        'is_holiday',
        'is_active'
    ];

    //Orchid filters and sorts
    protected array $allowedFilters = [
        'id' => Where::class,
        'name' => Like::class,
        'start' => WhereDateStartEnd::class,
        'end' => WhereDateStartEnd::class,
        'is_holiday' => Where::class,
        'is_active' => Where::class,
        'created_at' => WhereDateStartEnd::class,
        'updated_at' => WhereDateStartEnd::class
    ];

    protected array $allowedSorts = [
        'id',
        'name',
        'start',
        'end',
        'created_at',
        'updated_at'
    ];

    //Casts and mutators

    /**
     * @return string
     */
    public function getNameWithDatesAttribute(): string
    {
        return $this->attributes['name']
               . ' (c ' . CarbonImmutable::make($this->attributes['start'])->format('d.m.Y')
               . ' по ' . CarbonImmutable::make($this->attributes['end'])->format('d.m.Y') . ')';
    }

    // Scopes

    /**
     * @param Builder $query
     * @return void
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    // Relations

    /**
     * @return HasMany
     */
    public function prices(): HasMany
    {
        return $this->hasMany(Price::class);
    }
}
