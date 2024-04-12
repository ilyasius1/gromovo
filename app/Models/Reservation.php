<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ReservationStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Filters\Types\WhereIn;
use Orchid\Screen\AsSource;

/**
 * @property int id
 * @property int cottage_id
 * @property int customer_profile_id
 * @property string start
 * @property string end
 * @property int amount
 * @property string pay_before
 * @property ReservationStatus status
 * @property string created_at
 * @property string updated_at
 *
 * @method static Builder|Reservation query()
 * @method static Reservation create(array $fields)
 * @method Builder|Reservation active()
 * @method static Builder|Reservation filters()
 * @method static Builder|Reservation defaultSort(string $column, string $direction = 'asc')
 */
class Reservation extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;

    protected $fillable = [
        'cottage_id',
        'customer_profile_id',
        'start',
        'end',
        'amount',
        'contract_number',
        'pay_before',
        'status'
    ];

    //Casts and mutators
    protected $casts = [
        'status' => ReservationStatus::class,
    ];

    //Orchid filters and sorts
    protected array $allowedFilters = [
        'id' => Where::class,
        'cottage_id' => WhereIn::class,
        'customer_profile_id' => Where::class,
        'start' => WhereDateStartEnd::class,
        'end' => WhereDateStartEnd::class,
        'status' => WhereIn::class,
        'created_at' => WhereDateStartEnd::class,
        'updated_at' => WhereDateStartEnd::class
    ];

    protected array $allowedSorts = [
        'id',
        'cottage_id',
        'start',
        'end',
        'status',
        'created_at',
        'updated_at'
    ];

    //Relations
    public function cottage(): BelongsTo
    {
        return $this->belongsTo(Cottage::class, 'cottage_id');
    }

    public function customerProfile(): BelongsTo
    {
        return $this->belongsTo(CustomerProfile::class, 'customer_profile_id');
    }
}
