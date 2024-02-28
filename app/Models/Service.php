<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereIn;
use Orchid\Screen\AsSource;

/**
 * @property int id
 * @property string name
 * @property int service_category_id
 * @property string attention
 * @property int price
 * @property int price_per_hour
 * @property int price_per_day
 *
 * @method static Builder|Service query()
 * @method static Service create()
 * @method Builder|Service active()
 */
class Service extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $fillable = [
        'name',
        'service_category_id',
        'attention',
        'price',
        'price_per_hour',
        'price_per_day'
    ];

    //Orchid filters and sorts
    protected array $allowedFilters = [
        'id' => Where::class,
        'name' => Where::class,
        'service_category_id' => WhereIn::class
    ];

    protected array $allowedSorts = [
        'id',
        'name',
        'service_category_id',
        'price',
        'price_per_hour',
        'price_per_day'
    ];

    //Relations

    /**
     * @return BelongsTo
     */
    public function serviceCategory(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

}
